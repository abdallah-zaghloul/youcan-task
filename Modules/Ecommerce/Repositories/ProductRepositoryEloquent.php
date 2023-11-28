<?php

namespace Modules\Ecommerce\Repositories;

use Modules\Ecommerce\Models\Product;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Ecommerce\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/** Cache Implementation accTo Repository Config */
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;


/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace Modules\Ecommerce\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository, CacheableInterface
{
    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Product::class;
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
