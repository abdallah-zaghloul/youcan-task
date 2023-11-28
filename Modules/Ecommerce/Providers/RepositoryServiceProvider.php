<?php

namespace Modules\Ecommerce\Providers;

use Illuminate\Support\ServiceProvider;

/**
 *
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(\Modules\Ecommerce\Repositories\CategoryRepository::class, \Modules\Ecommerce\Repositories\CategoryRepositoryEloquent::class);
        $this->app->bind(\Modules\Ecommerce\Repositories\ProductRepository::class, \Modules\Ecommerce\Repositories\ProductRepositoryEloquent::class);
        //:end-bindings:
    }
}
