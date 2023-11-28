<?php

namespace Modules\Ecommerce\Criteria;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ecommerce\Models\Product;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class RequestCriteria.
 *
 * @package namespace Modules\Persona\Criteria;
 */
class IndexProductCriteria implements CriteriaInterface
{
    /**
     * @var Builder
     */
    protected Builder $builder;


    /**
     */
    public function __construct()
    {
        /**
         * this isn't a model call outside repo : this is a reusable query layer for model used within repository by calling $repository->pushCriteria();
         */
        $this->builder = Product::query()->with('categories');
    }


    /**
     * @return $this
     */
    protected function categoryNameFilter(): static
    {
        $this->builder->when(request()->filled('categoryName'),
            fn(Builder $builder) => /** query using whereExists more readable*/
            $this->builder->whereRelation('categories', 'name', 'like', "%" . request()->query('categoryName') . "%")

        /** query using joins (maybe more performant but not readable)
         * $this->builder->join('category_product','products.id','=','category_product.product_id')
         * ->leftJoin('categories', fn(JoinClause $join) => $join->on('category_product.category_id','=','categories.id')
         * ->where('categories.name','like',"%".request()->query('categoryName')."%"))
         */
        );

        return $this;
    }


    /**
     * @return $this
     */
    protected function sortBy(): static
    {
        $this->builder->when(request()->filled('sortBy'),
            fn(Builder $builder) => $this->builder->orderBy(request()->query('sortBy'), request()->query('dir', 'asc')),
            fn(Builder $builder) => $this->builder->latest()
        );

        return $this;
    }


    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return Builder|Model|mixed
     * @throws Exception
     */
    public function apply($model, RepositoryInterface $repository): mixed
    {
        return $this->categoryNameFilter()
            ->sortBy()
            ->builder;
    }
}
