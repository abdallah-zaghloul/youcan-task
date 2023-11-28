<?php

namespace Modules\Persona\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Persona\Criteria\RequestCriteria;
use Modules\Persona\Repositories\UserRepository;
use Modules\Persona\Models\User;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace Modules\Persona\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
