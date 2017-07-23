<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sensors extends Model implements
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
        'trunk_id', 'category_id', 'name', 'password',
    ];

    protected $table = 'sensors';

    protected $hidden = [
        'password', 'remember_token',
    ];
}
