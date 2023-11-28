<?php

namespace Modules\Ecommerce\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Category.
 *
 * @package namespace Modules\Ecommerce\Models;
 */
class Category extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'categories';


    /**
     * @var bool
     */
    public $timestamps = true;


    /**
     * The hidden attributes.
     *
     * @var array
     */
    protected $hidden = [
        'pivot',
        'batch_id'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'batch_id'
    ];


    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }


    /**
     * @return HasMany
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }


    /**
     * @return BelongsTo
     */
    public function mainCategory(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id', 'subCategories');
    }


    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product')
            ->using(CategoryProduct::class)
            ->withTimestamps();
    }

}
