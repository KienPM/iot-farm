<?php

namespace App\Http\Controllers\Core\Traits;

use App\Core\Responses\Store\ManageResponse;

trait StoreManageTrait
{
    public function update(Store $store, Request $request)
    {
        $this->validateUpdateRequest($request, $store);

        try {
            $storeData = $request->only($this->updateFields);
            $store->update($storeData);

            return ManageResponse::updateStoreResponse('success', $store->load(['partner']));
        } catch (Exception $e) {
            return ManageResponse::updateStoreResponse('error');
        }
    }

    protected function createOrUpdate($storeData, $id = null)
    {
        return Store::updateOrCreate(['id' => $id], $storeData);
    }

    // protected function basicResult($status, $data = null)
    // {
    //     $response = [
    //         'status' => config('status.' . $status),
    //         'message' => trans('response.create_' . $status, ['name' => trans('name.store')]),
    //     ];
    //     if ($data !== null) {
    //         $response['data'] = $data;
    //     }

    //     return $this->response($response);
    // }
}
