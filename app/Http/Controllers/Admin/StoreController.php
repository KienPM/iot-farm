<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Http\Controllers\Core\StoreController as BaseController;

class StoreController extends BaseController
{
    protected $guard = 'admin';

    public function devices(Store $store)
    {
        return $store->load(['devices.category']);
    }

    public function create(Request $request)
    {
        return 1;
        // return $store->load(['devices.category']);
    }
}
