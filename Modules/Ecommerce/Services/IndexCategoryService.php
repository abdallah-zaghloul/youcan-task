<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Modules\Ecommerce\Services;

use Modules\Ecommerce\Criteria\IndexCategoryCriteria;
use Modules\Ecommerce\Repositories\CategoryRepository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 *
 */
class IndexCategoryService
{
    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     *
     */
    public function __construct()
    {
        $this->categoryRepository = app(CategoryRepository::class);
    }


    /**
     * @throws RepositoryException
     */
    public function execute()
    {
        return $this->categoryRepository->pushCriteria(IndexCategoryCriteria::class)->cursor();
    }
}
