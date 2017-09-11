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

    public function trunkStatus(Store $store, Trunk $trunk, Request $request)
    {
        $user = $request->user();
        try {
            if (!$this->checkMyStore($store, $user)) {
                throw new Exception('Store not found!');
            }
            if ($trunk->store_id != $store->id) {
                throw new Exception('Trunk not in this store!');
            }
            $all = $request->get('all', 0);
            if ($all) {
                $trunkStatus = $trunk->status()->get()->toArray();
                $trunkStatus = [
                    'data' => $trunkStatus,
                ];
            } else {
                $itemPerPage = $request->get('items_per_page', Trunk::ITEMS_PER_PAGE);
                $trunkStatus = $trunk->status()->paginate($itemPerPage)->toArray();
            }
            return TrunkResponse::listTrunkResponse('success', $trunkStatus);

        } catch (Exception $e) {
            return TrunkResponse::listTrunkResponse('error');
        }
    }

    public function trunksStatus(Store $store, Request $request)
    {
        $user = $request->user();
        try {
            if (!$this->checkMyStore($store, $user)) {
                throw new Exception('Store not found!');
            }
            $all = $request->get('all', 0);
            if ($all) {
                $trunks = collect($store->trunks()->with('status')->get()->toArray());
                $trunks->transform(function ($trunk) {
                    $trunk['status'] = count($trunk['status']) > 0 ? $trunk['status'][0] : null;
                    return $trunk;
                });
                $trunks = [
                    'data' => $trunks,
                ];
            } else {
                $itemPerPage = $request->get('items_per_page', Trunk::ITEMS_PER_PAGE);
                $trunks = $store->trunks()->with('status')->paginate($itemPerPage)->toArray();

                $trunks['data'] = collect($trunks['data'])->transform(function ($trunk) {
                    $trunk['status'] = count($trunk['status']) > 0 ? $trunk['status'][0] : null;
                    return $trunk;
                });
            }
            return TrunkResponse::listTrunkResponse('success', $trunks);

        } catch (Exception $e) {
            return TrunkResponse::listTrunkResponse('error');
        }
    }

    public function updateTrunksStatus(Store $store, Request $request)
    {
        $user = $request->user();
        try {
            if (!$this->checkMyStore($store, $user)) {
                throw new Exception('Store not found!');
            }
            $trunksStatus = collect($request->get('trucks_status', []));
            $trunks = $store->trunks()->get();
            $trunksId = $trunks->pluck('id');
            if ($trunks->isEmpty()) {
                throw new Exception('Not found trunk in the store!');
            }
            $trunksStatusInsert = $trunksStatus->filter(function ($trunkStatus) use ($trunksId) {
                return $trunksId->has($trunkStatus['trunk_id']);
            });
            DB::table('trunk_status')->insert($trunksStatusInsert->toArray());
            return TrunkResponse::updateTrunkResponse('success');
        } catch (Exception $e) {
            return TrunkResponse::updateTrunkResponse('warning');
        }
    }

    protected function validateTrucksStatusRequest(Request $request)
    {
        $rules = [
            'trucks_status' => 'required|array',
            'trucks_status.*.trunk_id' => 'required|exists:trunks,id',
            'trucks_status.*.vegetable_id' => 'required|exists:vegetable,id',
            'trucks_status.*.number_grow_day' => 'required|interger',
            'trucks_status.*.planting_day' => 'required|date',
            'trucks_status.*.basket_1' => 'boolean',
            'trucks_status.*.basket_2' => 'boolean',
            'trucks_status.*.basket_3' => 'boolean',
            'trucks_status.*.basket_4' => 'boolean',
            'trucks_status.*.basket_5' => 'boolean',
            'trucks_status.*.basket_6' => 'boolean',
            'trucks_status.*.basket_7' => 'boolean',
            'trucks_status.*.basket_8' => 'boolean',
            'trucks_status.*.basket_9' => 'boolean',
            'trucks_status.*.basket_10' => 'boolean',
            'trucks_status.*.basket_11' => 'boolean',
            'trucks_status.*.basket_12' => 'boolean',
            'trucks_status.*.basket_13' => 'boolean',
        ];

        return $this->validate($request, $rules);
    }

    protected function checkMyStore(Store $store, $user)
    {
        if ($store->partner_id == $user->id) {
            return true;
        }
        return false;
    }
}
