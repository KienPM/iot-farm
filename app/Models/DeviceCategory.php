<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DeviceCategory
 *
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceCategory whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DeviceCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'symbol', 'description',
    ];

    protected $table = 'device_categories';
}
