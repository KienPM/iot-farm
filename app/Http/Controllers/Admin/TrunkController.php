<?php

namespace App\Http\Controllers\Admin;

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
    protected $guard = 'admin';

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

    public function trunksStatus(Store $store, Request $request)
    {
        try {
            $all = $request->get('all', 0);
            if ($all) {
                $trunks = collect($store->trunks()->with('status')->get()->toArray());
                $trunks->transform(function ($trunk) {
                    $trunk['status'] = count($trunk['status']) > 0 ? $trunk['status'][0] : null;
                    return $trunk;
                });
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
        try {
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
}
