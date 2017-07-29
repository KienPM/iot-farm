<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Core\QueryFilter\StoreFilter;

abstract class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    public function index(Request $request, StoreFilter $query)
    {
        $itemPerPage = $request->get('items_per_page', Store::ITEMS_PER_PAGE);
        return Store::filterBy($query)->with('partner')->paginate($itemPerPage);
    }

    public function show(Store $store)
    {
        return $store->load(['partner', 'vegetables']);
    }
}
