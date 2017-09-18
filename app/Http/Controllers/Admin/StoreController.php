<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Trunk;
use App\Models\Device;
use App\Http\Controllers\Core\StoreController as BaseController;
use App\Http\Controllers\Core\Traits\StoreManageTrait;
use Exception;
use App\Core\Responses\Trunk\TrunkResponse;
use App\Core\Responses\Store\ManageResponse;
use DB;

class StoreController extends BaseController
{
    use StoreManageTrait;

    protected $guard = 'admin';
    protected $updateFields = ['partner_id', 'logo', 'name', 'address', 'phone_number', 'info', 'latitude', 'longitude', 'is_actived'];

    public function devices(Store $store, Request $request)
    {
        $itemPerPage = $request->get('items_per_page', Device::ITEMS_PER_PAGE);
        $devices = $store->devices()->with([
            'category' => function ($q) {
                $q->select(['id', 'name', 'symbol']);
            }
        ])->paginate($itemPerPage)->toArray();

        return ManageResponse::response(
            'success',
            config('response.get_store_detail_success'),
            $devices
        );
    }

    public function create(Request $request)
    {
        $this->validateCreateRequest($request);

        try {
            DB::beginTransaction();
            $storeData = $request->only([
                'partner_id',
                'name',
                'address',
                'phone_number',
                'info',
                'latitude',
                'longitude',
                'is_actived',
            ]);
            $store = $this->createOrUpdate($storeData);
            $this->createTrunk($store, $request);
            DB::commit();

            return ManageResponse::createStoreResponse('success', $store->toArray());
        } catch (Exception $e) {
            DB::rollBack();
            return ManageResponse::createStoreResponse('error');
        }
    }

    public function addTrunks(Store $store, Request $request)
    {
        $addRules = [
            'trunks_count' => 'required|integer',
        ];
        $this->validate($request, $addRules);
        try {
            $trunkTop = $store->trunks()->orderBy('code', 'desc')->first();
            $startCode = 1;
            if ($trunkTop) {
                $startCode = $trunkTop->code + 1;
            }
            $this->createTrunk($store, $request, $startCode);

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

    public function delete(Store $store)
    {
        try {
            DB::beginTransaction();
            $store->devices()->delete();
            $store->vegetables()->detach();
            $store->delete();

            DB::commit();
            return ManageResponse::deleteStoreResponse('success');
        } catch (Exception $e) {
            DB::rollBack();
            return ManageResponse::deleteStoreResponse('error');
        }

    }

    public function changeStatus(Store $store, Request $request)
    {
        $status = $request->get('status', false);
        try {
            DB::beginTransaction();
            $store->devices()->update(['is_actived' => $status]);
            $store->update(['is_actived' => $status]);

            DB::commit();
            return ManageResponse::updateStoreResponse('success');
        } catch (Exception $e) {
            DB::rollBack();
            return ManageResponse::updateStoreResponse('error');
        }
    }

    protected function validateUpdateRequest($request, $store)
    {
        $updateRules = [
            'partner_id' => 'required|exists:partners,id',
            'logo' => 'string',
            'name' => 'string',
            'address' => 'required:string',
            'phone_number' => 'numeric',
            'info' => 'max:50000',
            'is_actived' => 'boolean',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
        ];

        return $this->validate($request, $updateRules);
    }

    protected function validateCreateRequest($request)
    {
        $createRules = [
            'partner_id' => 'required|exists:partners,id',
            'logo' => 'string',
            'name' => 'string',
            'address' => 'required:string',
            'phone_number' => 'numeric',
            'info' => 'max:50000',
            'is_actived' => 'boolean',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'trunks_count' => 'required|integer',
        ];

        return $this->validate($request, $createRules);
    }

    protected function createTrunk($store, $request, $startCode = 1)
    {
        $trunksCount = $request->get('trunks_count', 0);
        $maxCode = $startCode + $trunksCount;
        $trunks = [];
        if ($trunksCount) {
            for ($i = $startCode; $i < $maxCode; $i++) {
                $trunks[] = [
                    'code' => $i,
                ];
            }

            $store->trunks()->createMany($trunks);
        }
    }
}
