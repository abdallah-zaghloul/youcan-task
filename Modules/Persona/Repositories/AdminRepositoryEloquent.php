<?php

namespace Modules\Persona\Repositories;

use Modules\Persona\Models\Admin;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Persona\Criteria\RequestCriteria;

/**
 * Class AdminRepositoryEloquent.
 *
 * @package namespace Modules\Persona\Repositories;
 */
class AdminRepositoryEloquent extends BaseRepository implements AdminRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admin::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
