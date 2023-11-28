<?php

namespace Modules\Persona\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Persona\Models\Admin;

/**
 * Class AdminTransformer.
 *
 * @package namespace Modules\Persona\Transformers;
 */
class AdminTransformer extends TransformerAbstract
{
    /**
     * Transform the Admin entity.
     *
     * @param Admin $model
     *
     * @return array
     */
    public function transform(Admin $model)
    {
        return [
            'id'         => $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
