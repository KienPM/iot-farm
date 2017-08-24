<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Http\Controllers\Core\StoreController as BaseController;
// use App\Http\Controllers\Core\Contracts\StoreManageContract;
use App\Http\Controllers\Core\Traits\StoreManageTrait;
use Exception;
use App\Core\Responses\Store\ManageResponse;
use DB;

class StoreController extends BaseController
{
    use StoreManageTrait;

    protected $guard = 'admin';
    protected $updateFields = ['partner_id', 'address', 'info', 'latitude', 'longitude', 'is_actived'];

    public function devices(Store $store)
    {
        return ManageResponse::response(
            'success',
            config('response.get_store_detail_success'),
            ['data' => $store->load([
                'devices' => function ($query) {
                    $query->with([
                        'category' => function ($q) {
                            $q->select(['id', 'name', 'symbol']);
                        }
                    ]);
                }
            ])]
        );
    }

    public function create(Request $request)
    {
        $this->validateCreateRequest($request);

        try {
            $storeData = $request->only([
                'partner_id',
                'address',
                'info',
                'latitude',
                'longitude',
                'is_actived',
            ]);
            $store = $this->createOrUpdate($storeData);

            return ManageResponse::createStoreResponse('success', $store->toArray());
        } catch (Exception $e) {
            return ManageResponse::createStoreResponse('error');
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
        return $this->validateCreateRequest($request);
    }

    protected function validateCreateRequest($request)
    {
        $createRules = [
            'partner_id' => 'required|exists:partners,id',
            'address' => 'required:string',
            'info' => 'max:50000',
            'is_actived' => 'boolean',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
        ];

        return $this->validate($request, $createRules);
    }
}
