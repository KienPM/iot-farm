<?php

namespace App\Models;

class Partner extends BaseUser
{
    const ITEMS_PER_PAGE = 10;

    protected $table = 'partners';

    public function activeStores()
    {
        return $this->hasMany(Store::class)->active();
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
