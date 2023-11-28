<?php

namespace Modules\Ecommerce\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Ecommerce\Http\Requests\CreateProductRequest;
use Modules\Ecommerce\Http\Requests\IndexProductRequest;
use Modules\Ecommerce\Services\CreateProductService;
use Modules\Ecommerce\Services\IndexProductService;
use Modules\Ecommerce\Traits\Response;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 *
 */
class ProductsController extends Controller
{
    use Response;

    /**
     * Display a listing of the resource.
     * @param IndexProductService $service
     * @param IndexProductRequest $request
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function index(IndexProductService $service, IndexProductRequest $request): JsonResponse
    {
        $products = $service->execute($request);
        return $this->dataResponse(compact('products'));
    }


    /**
     * @param CreateProductService $service
     * @param CreateProductRequest $request
     * @return JsonResponse
     */
    public function create(CreateProductService $service, CreateProductRequest $request): JsonResponse
    {
        $product = $service->execute($request);
        return $this->dataResponse(compact('product'));
    }
}
