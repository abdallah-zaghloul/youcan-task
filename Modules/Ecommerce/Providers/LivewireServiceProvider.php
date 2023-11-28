<?php

namespace Modules\Ecommerce\Providers;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Ecommerce\Components\IndexProductsComponent;

/**
 *
 */
class LivewireServiceProvider extends ServiceProvider
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
        Livewire::component('ecommerce::products',IndexProductsComponent::class);
        Livewire::component('ecommerce::categories',IndexCategoriesComponent::class);
    }
}
