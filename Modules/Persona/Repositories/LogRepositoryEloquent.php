<?php

namespace Modules\Persona\Repositories;

use Modules\Persona\Criteria\RequestCriteria;
use Modules\Persona\Models\Log;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

/** Cache Implementation accTo Repository Config */

/**
 * Class LogRepositoryEloquent.
 *
 * @package namespace Modules\Persona\Repositories;
 */
class LogRepositoryEloquent extends BaseRepository implements LogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Log::class;
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
