<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Modules\Ecommerce\Services;

use Modules\Ecommerce\Criteria\IndexProductCriteria;
use Modules\Ecommerce\Http\Requests\IndexProductRequest;
use Modules\Ecommerce\Repositories\ProductRepository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 *
 */
class IndexProductService
{
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
     * @throws RepositoryException
     */
    public function execute(?IndexProductRequest $request = null)
    {
        $request ??= request();
        return $this->productRepository->pushCriteria(app(IndexProductCriteria::class))
            ->cursorPaginate($request->getPaginationCount())
            ->appends($request->query());
    }
}
