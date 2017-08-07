<?php

namespace App\Models;

class User extends BaseUser
{
    protected $table = 'users';

    public function socialUsers()
    {
        return $this->hasMany(SocialUser::class);
    }
}
