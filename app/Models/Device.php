<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Models\Traits\Activeable;
use App\Models\Traits\Filterable;

/**
 * App\Models\Device
 *
 * @property int $id
 * @property int $store_id
 * @property int $category_id
 * @property string $name
 * @property string $identify_code
 * @property string $password
 * @property int $is_actived
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\DeviceCategory $category
 * @property-read \App\Models\Store $store
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device filterBy(\App\Core\QueryFilter\QueryFilter $queryFilter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereIdentifyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereIsActived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Device extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable, Activeable, Filterable;

    const ITEMS_PER_PAGE = 10;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identify_code', 'store_id', 'category_id', 'name', 'password', 'is_actived',
    ];

    protected $table = 'devices';

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(DeviceCategory::class);
    }

    public function isActive()
    {
        return $this->is_actived;
    }
}
