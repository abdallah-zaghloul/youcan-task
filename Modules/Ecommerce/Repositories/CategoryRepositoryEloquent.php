<?php

namespace Modules\Ecommerce\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Ecommerce\Criteria\RequestCriteria;
use Modules\Ecommerce\Models\Category;
use Prettus\Repository\Exceptions\RepositoryException;

/** Cache Implementation accTo Repository Config */
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace Modules\Ecommerce\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository, CacheableInterface
{
    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Category::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
