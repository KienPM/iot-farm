<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Trunk;
use App\Models\TrunkStatus;
use App\Http\Controllers\Controller;
use Exception;
use App\Core\Responses\Trunk\TrunkResponse;
use DB;
use App\Core\Responses\Store\ManageResponse;

class TrunkController extends Controller
{
    protected $guard = 'partner';


    public function index(Store $store, Request $request)
    {
        try {
            $all = $request->get('all', 0);
            if ($all) {
                $trunks = ['data' => $store->trunks()->get()->toArray()];
            } else {
                $itemPerPage = $request->get('items_per_page', Trunk::ITEMS_PER_PAGE);
                $trunks = $store->trunks()->paginate($itemPerPage)->toArray();
            }

            return TrunkResponse::listTrunkResponse('success', $trunks);
        } catch (Exception $e) {
            return TrunkResponse::listTrunkResponse('error');
        }
    }
}
