<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Core\StoreController as BaseController;
use App\Models\Store;
use Exception;
use App\Http\Controllers\Core\Contracts\StoreManageContract;
use App\Http\Controllers\Core\Train\StoreManageTrain;
use App\Core\Responses\ManageResponse;

class StoreController extends BaseController implements StoreManageContract
{
    use StoreManageTrain;

    protected $guard = 'partner';
    protected $updateFields = ['address', 'info'];

    protected function validateUpdateRequest($request, $store)
    {
        if ($request->user()->id !== $store->partner_id) {
            return ManageResponse::cantContinue();
        }

        $updateRules = [
            'address' => 'required:string',
            'info' => 'max:50000',
        ];

        return $this->validate($request, $updateRules);
    }
}
