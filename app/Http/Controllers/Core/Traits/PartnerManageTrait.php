<?php

namespace App\Http\Controllers\Core\Traits;

use App\Core\Responses\Store\ManageResponse;

trait PartnerManageTrait
{
    protected function validateCreateRequest($request)
    {
        $createRules = [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'numeric',
            'is_actived' => 'boolean',
        ];

        return $this->validate($request, $createRules);
    }

    protected function validateUpdateRequest($request)
    {
        $updateRules = [
            'name' => 'string',
            'email' => 'email',
            'phone_number' => 'numeric',
            'is_actived' => 'boolean',
        ];

        return $this->validate($request, $updateRules);
    }

    protected function updateOrCreate($storeData, $id = null)
    {
        return Partner::updateOrCreate(['id' => $id], $storeData);
    }
}
