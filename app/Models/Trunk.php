<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trunk extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id', 'code',
    ];

    protected $table = 'strunks';
}
