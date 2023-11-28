<?php

namespace Modules\Ecommerce\Providers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Ecommerce\Console\CreateProductCommand;

/**
 *
 */
class EcommerceServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected string $moduleName = 'Ecommerce';

    /**
     * @var string
     */
    protected string $moduleNameLower = 'ecommerce';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->bootMacros();
        $this->bootConfigs();
    }


    /**
     * @return void
     */
    public function bootConfigs(): void
    {
        $this->overrideViewConfigs();
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
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(LivewireServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
         $this->commands([
             CreateProductCommand::class
         ]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }


    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower.'.php')], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower);
    }


    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.config('modules.paths.generator.component-class.path'));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }


    /**
     * Get the services provided by the provider.
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
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }
}
