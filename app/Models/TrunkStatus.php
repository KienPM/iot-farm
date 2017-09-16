<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrunkStatus extends Model
{
    const ITEMS_PER_PAGE = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trunk_id',
        'vegetable_id',
        'number_grow_day',
        'planting_day',
        'pump',
        'basket_1',
        'basket_2',
        'basket_3',
        'basket_4',
        'basket_5',
        'basket_6',
        'basket_7',
        'basket_8',
        'basket_9',
        'basket_10',
        'basket_11',
        'basket_12',
        'basket_13',
    ];

    protected $table = 'trunk_status';

    public function trunk()
    {
        return $this->belongsTo(Trunk::class);
    }

    public function vegetable()
    {
        return $this->belongsTo(Vegetable::class);
    }
}
