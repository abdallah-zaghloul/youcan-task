<?php

namespace Modules\Ecommerce\Tests\Unit;

use Modules\Ecommerce\Database\factories\ProductFactory;
use Modules\Ecommerce\Http\Requests\CreateProductRequest;
use Modules\Ecommerce\Services\CreateProductService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductTest extends TestCase
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
        $request = $this->app->make(CreateProductRequest::class)->merge($productData);
        $product = $this->app->make(CreateProductService::class)->execute($request);
        $this->assertNotEmpty($product);
    }
}
