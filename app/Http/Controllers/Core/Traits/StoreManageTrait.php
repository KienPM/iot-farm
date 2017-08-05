<?php

namespace App\Http\Controllers\Core\Traits;

use App\Core\Responses\Store\ManageResponse;

trait StoreManageTrait
{
    use BaseManageTrait;

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
}
