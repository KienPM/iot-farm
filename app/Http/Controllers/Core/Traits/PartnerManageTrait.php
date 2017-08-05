<?php

namespace App\Http\Controllers\Core\Traits;

use App\Core\Responses\Store\ManageResponse;

trait PartnerManageTrait
{
    use BaseManageTrait;

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
        $this->validateCreateRequest($request);
    }

    protected function createOrUpdate($storeData, $id = null)
    {
        return Partner::updateOrCreate(['id' => $id], $storeData);
    }
}
