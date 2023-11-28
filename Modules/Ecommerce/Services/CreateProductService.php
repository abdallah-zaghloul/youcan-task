<?php

namespace Modules\Ecommerce\Services;

use Illuminate\Support\Facades\DB;
use Modules\Ecommerce\Enums\HttpStatusCodeEnum;
use Modules\Ecommerce\Http\Requests\CreateProductRequest;
use Modules\Ecommerce\Repositories\ProductRepository;
use Modules\Ecommerce\Traits\Response;

/**
 *
 */
class CreateProductService
{
    use Response;

    /**
     * @var ProductRepository
     */
    protected ProductRepository $productRepository;


    /**
     *
     */
    public function __construct()
    {
        $this->productRepository = app(ProductRepository::class);
    }


    /**
     * @param CreateProductRequest $request
     * @return mixed
     */
    public function execute(CreateProductRequest $request): mixed
    {
        try {

            DB::beginTransaction();
            $product = $this->productRepository->create($request->only(['name', 'description', 'price', 'image']));
            $request->filled('category_ids') and $product->categories()->syncWithoutDetaching($request->get('category_ids'));
            DB::commit();
            return $product->refresh()->load('categories');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->expectsJson())
                $this->errorMessage(message: trans("ecommerce::messages.unavailable_server"), errorHttpCode: HttpStatusCodeEnum::UnavailableServer);
            else abort(HttpStatusCodeEnum::UnavailableServer->value);
        }
    }

}
