<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CartItem
 *
 * @property int $id
 * @property int $cart_id
 * @property int $vegetable_in_store_id
 * @property int $checked
 * @property int $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Vegetable $vegetableInStore
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartItem whereVegetableInStoreId($value)
 * @mixin \Eloquent
 */
class CartItem extends Model
{
    const ITEMS_PER_PAGE = 10;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'vegetable_in_store_id', 'checked', 'quantity'
    ];

    protected $table = 'cart_item';

    public function vegetableInStore()
    {
        return $this->belongsTo(VegetableInStore::class);
    }
}
