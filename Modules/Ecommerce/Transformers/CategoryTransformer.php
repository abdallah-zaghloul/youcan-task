<?php

namespace Modules\Ecommerce\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Ecommerce\Models\Category;

/**
 * Class CategoryTransformer.
 *
 * @package namespace Modules\Ecommerce\Transformers;
 */
class CategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the Category entity.
     *
     * @param Category $model
     *
     * @return array
     */
    public function transform(Category $model): array
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
