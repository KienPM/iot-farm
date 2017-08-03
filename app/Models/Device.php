<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Device extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

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

    public function scopeActive($query)
    {
        return $query->where('is_actived', true);
    }
}
