<?php

namespace App\Models;

class Partner extends BaseUser
{
    protected $table = 'partners';

    public function stores()
    {
        return $this->hasMany(Stores::class)->where('is_actived', true);
    }

    public function allStores()
    {
        return $this->hasMany(Stores::class);
    }
}
