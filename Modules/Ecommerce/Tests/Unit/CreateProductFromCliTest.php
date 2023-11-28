<?php

namespace Modules\Ecommerce\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Modules\Ecommerce\Database\factories\ProductFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductFromCliTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_product()
    {
        $productData = $this->app->make(ProductFactory::class)->definition();
        $this->artisan("create:product '{$productData['name']}' {$productData['price']} --description='{$productData['description']}'")
            ->assertSuccessful();
    }
}
