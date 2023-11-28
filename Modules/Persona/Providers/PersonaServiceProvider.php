<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Modules\Persona\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Modules\Persona\Http\Middleware\Authenticate;
use App\Http\Kernel;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Modules\Persona\Http\Middleware\EnsureEmailIsVerified;
use Modules\Persona\Http\Middleware\Log;
use Modules\Persona\Http\Middleware\RedirectIfAuthenticated;
use Modules\Persona\Models\Admin;
use Modules\Persona\Models\User;


/**
 *
 */
class PersonaServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected string $moduleName = 'Persona';

    /**
     * @var string $moduleNameLower
     */
    protected string $moduleNameLower = 'persona';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->bootMacros();
        $this->bootConfigs();
        $this->bootMiddlewares();
    }

    /**
     * @return void
     */
    public function bootConfigs(): void
    {
        $this->overrideAuthenticationConfigs();
        $this->overrideViewConfigs();
    }


    /**
     * @return void
     */
    public function overrideAuthenticationConfigs(): void
    {
        config(['auth' => array_replace_recursive(
            config('auth'),
            $this->userAuthenticationConfigs(),
            $this->adminAuthenticationConfigs()
        )]);
    }


    /**
     * @return \array[][]
     */
    public function userAuthenticationConfigs(): array
    {
        return [
            'providers'=> ['users' => ['driver' => 'eloquent', 'model' => User::class]],
            'guards'=> ['web' => ['driver' => 'session', 'provider' => 'users']],
            'passwords'=> ['users' => [
                'provider' => 'users',
                'table' => 'password_reset_tokens',
                'expire' => 60,
                'throttle' => 60
            ]],
        ];
    }


    /**
     * @return \array[][]
     */
    public function adminAuthenticationConfigs(): array
    {
        return [
            'providers'=> ['admins' => ['driver' => 'eloquent', 'model' => Admin::class]],
            'guards'=> ['adminWeb' => ['driver' => 'session', 'provider' => 'admins']],
            'passwords'=> ['admins' => [
                'provider' => 'admins',
                'table' => 'admin_password_reset_tokens',
                'expire' => 60,
                'throttle' => 60
            ]],
        ];
    }

    /**
     * @return void
     */
    public function overrideViewConfigs(): void
    {
        $this->overrideModulesLivewireConfigs();
        Paginator::useBootstrap();
        config(['livewire.pagination_theme' => 'bootstrap']);
    }

    /**
     * @return void
     */
    public function overrideModulesLivewireConfigs(): void
    {
        try {
            $modulesLivewireConfigs = config('modules-livewire');
            $modulesLivewireConfigs['namespace'] = "Services\\Web\\Components";
            $modulesLivewireConfigs['view'] = 'Resources/views/components';
            config(['modules-livewire' => $modulesLivewireConfigs]);
        }catch (\Exception $e){}
    }

    /**
     * @return void
     */
    public function bootMacros(): void
    {
        Request::macro('getPaginationCount', function () {
            return match (true) {
                ctype_digit($query = $this->query('paginationCount')) && $query <= 1000 => (int)$query,
                default => config('repository.pagination.limit', 50)
            };
        });
    }


    /**
     * @return void
     */
    public function bootMiddlewares(): void
    {
        $this->app['router']->aliasMiddleware('auth', Authenticate::class);
        $this->app['router']->aliasMiddleware('guest', RedirectIfAuthenticated::class);
        $this->app['router']->aliasMiddleware('verified', EnsureEmailIsVerified::class);
        $this->app['router']->aliasMiddleware('log', Log::class);
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(LivewireServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }

    /**
     * @return array
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
