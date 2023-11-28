<?php

namespace Modules\Ecommerce\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Modules\Ecommerce\Repositories\ProductRepository;

/**
 *
 */
class SeedEcommerceJob implements ShouldQueue
{
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var LazyCollection
     */
    protected LazyCollection $productsLazyCollection;

    /**
     * @var LazyCollection
     */

    protected LazyCollection $categoryLazyIds;
    /**
     * @var string
     */
    protected string $batch_id;


    /**
     * Create a new job instance.
     */
    public function __construct(LazyCollection $categoryLazyIds, LazyCollection $productsLazyCollection, string $batch_id)
    {
        $this->categoryLazyIds = $categoryLazyIds;
        $this->productsLazyCollection = $productsLazyCollection;
        $this->batch_id = $batch_id;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $productRepository = app(ProductRepository::class);
            DB::beginTransaction();

            $productRepository->insert($this->productsLazyCollection->toArray());
            $product_ids = $productRepository->inRandomOrder()->where('batch_id', $this->batch_id)->pluck('id');

            DB::table('category_product')->insert(
                $product_ids->map(fn($product_id) => [
                    'category_id' => $this->categoryLazyIds->random(),
                    'product_id' => $product_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])->all()
            );

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
        }

    }
}
