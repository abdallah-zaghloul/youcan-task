<?php

namespace Modules\Ecommerce\Tests\Feature;

use Modules\Ecommerce\Database\Seeders\EcommerceDatabaseSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_index_products(): void
    {
        $this->app->make(EcommerceDatabaseSeeder::class)->run(10, 100, 100);
        $response = $this->get(route('ecommerce.api.products.index'));
        $this->assertNotEmpty(@$response['data']['products']);
        $response->assertStatus(200);
    }
}
