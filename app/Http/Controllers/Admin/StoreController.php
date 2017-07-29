<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Http\Controllers\Core\StoreController as BaseController;

class StoreController extends BaseController
{
    protected $guard = 'admin';

    public function sensors(Store $store)
    {
        return $store->load(['devices.category']);
    }
}
