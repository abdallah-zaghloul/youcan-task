<?php

namespace Modules\Ecommerce\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Ecommerce\Models\Product;

/**
 * Class ProductTransformer.
 *
 * @package namespace Modules\Ecommerce\Transformers;
 */
class ProductTransformer extends TransformerAbstract
{
    /**
     * Transform the Category entity.
     *
     * @param Product $model
     *
     * @return array
     */
    public function transform(Product $model): array
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
