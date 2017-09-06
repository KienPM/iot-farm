<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Activeable;
use App\Models\Traits\Filterable;

/**
 * App\Models\Vegetable
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $is_actived
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vegetable active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vegetable filterBy(\App\Core\QueryFilter\QueryFilter $queryFilter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vegetable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vegetable whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vegetable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vegetable whereIsActived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vegetable whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vegetable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Vegetable extends Model
{
    use Activeable, Filterable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'is_actived',
    ];

    protected $table = 'vegetables';

    public function images()
    {
        return $this->belongsToMany(Image::class, 'vegetable_image');
    }
}
