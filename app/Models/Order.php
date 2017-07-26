<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const ORDER_SUBMITED = 1;
    const PAYMENT_CONFIRMED = 2;
    const ORDER_PROCESSING = 3;
    const ORDER_COMPLETED = 4;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'bank_account_id', 'store_id', 'total_price', 'status',
    ];

    protected $table = 'orders';
}
