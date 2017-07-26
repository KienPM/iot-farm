<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model
{
    const FACEBOOK_ACCOUNT = 1;
    const GOOGLE_ACCOUNT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'provider', 'provider_user_token',
    ];

    protected $table = 'social_users';
}
