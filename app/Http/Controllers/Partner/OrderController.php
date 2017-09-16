<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Trunk;
use App\Models\TrunkStatus;
use App\Http\Controllers\Controller;
use Exception;
use App\Core\Responses\Cart\OrderResponse;
use DB;
use App\Core\Responses\Store\ManageResponse;

class OrderController extends Controller
{
    protected $guard = 'partner';

    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    public function index(Store $store, Request $request)
    {
        $user = $request->user();
        try {
            if (!$this->checkMyStore($store, $user)) {
                throw new Exception('Store not found!');
            }
            $all = $request->get('all', 0);
            if ($all) {
                $orders = ['data' => $store->orders()->with('items.vegetablesInStore.vegetable')->get()->toArray()];
            } else {
                $itemPerPage = $request->get('items_per_page', Trunk::ITEMS_PER_PAGE);
                $orders = $store->orders()
                    ->with('items.vegetablesInStore.vegetable')
                    ->paginate($itemPerPage)
                    ->toArray();
            }

            return OrderResponse::listOrderResponse('success', $orders);
        } catch (Exception $e) {
            return OrderResponse::listOrderResponse('error');
        }
    }

    protected function checkMyStore(Store $store, $user)
    {
        if ($store->partner_id == $user->id) {
            return true;
        }
        return false;
    }
}
