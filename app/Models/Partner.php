<?php

namespace App\Models;

class Partner extends BaseUser
{
    protected $table = 'partners';

    public function stores()
    {
        return $this->hasMany(Store::class)->where('is_actived', true);
    }

    public function allStores()
    {
        return $this->hasMany(Store::class);
    }
}
