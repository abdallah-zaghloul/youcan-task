<?php

namespace Modules\Ecommerce\Http\Controllers\Web;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Ecommerce\Components\IndexProductsComponent;
use Modules\Ecommerce\Http\Requests\CreateProductRequest;
use Modules\Ecommerce\Services\CreateProductService;
use Modules\Ecommerce\Services\IndexCategoryService;
use Prettus\Repository\Exceptions\RepositoryException;

class ProductsController extends Controller
{

    /**
     * Show the form for creating a new resource.
     * @param IndexCategoryService $service
     * @return Renderable
     * @throws RepositoryException
     */
    public function create(IndexCategoryService $service): Renderable
    {
        return view('ecommerce::create-product',[
            'categories'=> $service->execute()
        ]);
    }

    /**
     * Store a new resource.
     * @param CreateProductRequest $request
     * @param CreateProductService $service
     * @return RedirectResponse
     */
    public function store(CreateProductRequest $request, CreateProductService $service): RedirectResponse
    {
        $service->execute($request);
        return redirect()->route('ecommerce.index');
    }
}
