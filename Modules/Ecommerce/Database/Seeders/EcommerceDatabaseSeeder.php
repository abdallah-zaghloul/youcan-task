<?php

namespace Modules\Ecommerce\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use Modules\Ecommerce\Database\factories\CategoryFactory;
use Modules\Ecommerce\Database\factories\ProductFactory;
use Modules\Ecommerce\Jobs\SeedEcommerceJob;
use Modules\Ecommerce\Repositories\CategoryRepository;
use Modules\Ecommerce\Repositories\CategoryRepositoryEloquent;
use Throwable;

class EcommerceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws Throwable
     */
    public function run(?int $batches = 100, ?int $records = 10000, ?int $categoryRecords = 1000, ?CategoryRepository $categoryRepository = null): void
    {
        Model::unguard();
        $categoryRepository ??= app(CategoryRepository::class);

        $categoriesLazyCollection = app(CategoryFactory::class)->count($categoryRecords)->make()->lazy();
        $categoryRepository->insert($categoriesLazyCollection->toArray());
        $categoryLazyIds = $categoryRepository->pluck('id')->lazy();

        /**
         * Seed parent category
         * ALTER TABLE table_name DISABLE KEYS;
         * ALTER TABLE table_name ENABLE KEYS;
         * SET FOREIGN_KEY_CHECKS=0;
         * SET FOREIGN_KEY_CHECKS=1;
         * DB::statement("");
         * DB::table('categories')->update(['parent_id' => DB::raw('RAND(id)')]);
         */

        for ($i = 0; $i < $batches; $i++) {
            $batch_id = Str::orderedUuid()->toString();
            $productsLazyCollection = app(ProductFactory::class)->count($records)->make(compact('batch_id'))->makeVisible('batch_id')->lazy();
            $seederJob = app(SeedEcommerceJob::class, compact('categoryLazyIds', 'productsLazyCollection', 'batch_id'));
            dispatch($seederJob);
        }

        /**
         * Using Bus Batch to fire all seeders job
         *  $jobs = [];
         *  $jobs[] = $seederJob;
         *  Bus::batch($jobs)->dispatch();
         */

    }
}
