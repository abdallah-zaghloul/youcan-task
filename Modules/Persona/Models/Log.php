<?php

namespace Modules\Persona\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Log.
 *
 * @package namespace Modules\Persona\Models;
 */
class Log extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'logs';


    /**
     * @var bool
     */
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'request',
        'response',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'request' => 'collection',
        'response' => 'collection'
    ];


    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
