<?php

namespace Modules\Ecommerce\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Product.
 *
 * @package namespace Modules\Ecommerce\Models;
 */
class Product extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table = 'products';


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
        'description',
        'price',
        'image',
        'batch_id'
    ];


    /**
     * @return Attribute
     */
    public function price(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => number_format((float)$value, '2', '.', ''),
        );
    }


    /**
     * @return Attribute
     */
    public function image(): Attribute
    {
        return Attribute::make(
            get: fn(?string $path = null) => @Storage::url($path ?? "ecommerce/products/no-product-image.png"),
            set: function (UploadedFile $file) {
                $file->storePubliclyAs("ecommerce/products", $name = Str::orderedUuid().".{$file->getClientOriginalExtension()}");
                return "ecommerce/products/$name";
            }
        );
    }


    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }


    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product')
            ->using(CategoryProduct::class)
            ->withTimestamps();
    }
}
