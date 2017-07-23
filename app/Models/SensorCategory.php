<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'unit',
    ];

    protected $table = 'sensor_categories';
}
