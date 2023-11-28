<?php

namespace Modules\Persona\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 *
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public const USER_HOME = 'home';
    public const ADMIN_HOME = 'admin';


    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Persona\Http\Controllers';


    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */


    public function boot()
    {
        parent::boot();
    }


    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Persona', '/Routes/web.php'));

        Route::middleware('web')
            ->prefix('admin')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Persona', '/Routes/adminWeb.php'));
    }


    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Persona', '/Routes/api.php'));
    }
}
