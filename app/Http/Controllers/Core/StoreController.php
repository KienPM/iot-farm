<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

abstract class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    public function index()
    {
        return Store::with('partner')->get();
    }

    public function show(Store $store)
    {
        return $store->load(['partner', 'vegetables']);
    }
}
