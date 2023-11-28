<?php

namespace Modules\Persona\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Persona\Models\User;

/**
 * Class UserTransformer.
 *
 * @package namespace Modules\Persona\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
