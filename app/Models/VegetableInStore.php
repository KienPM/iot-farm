<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VegetableInStore
 *
 * @property int $id
 * @property int $vegetable_id
 * @property int $store_id
 * @property int $price
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Store $store
 * @property-read \App\Models\Vegetable $vegetable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VegetableInStore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VegetableInStore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VegetableInStore wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VegetableInStore whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VegetableInStore whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VegetableInStore whereVegetableId($value)
 * @mixin \Eloquent
 */
class VegetableInStore extends Model
{
    protected $fillable = [
        'vegetable_id', 'store_id', 'price',
    ];

    protected $table = 'vegetable_in_store';

    public function vegetable()
    {
        return $this->belongsTo(Vegetable::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
