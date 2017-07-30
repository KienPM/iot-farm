<?php

namespace App\Http\Controllers\Device\Auth;

use App\Http\Controllers\Core\Auth\SessionController as BaseSessionController;

class SessionController extends BaseSessionController
{
    protected $guard = 'device';

    protected function identify()
    {
        return 'identify_code';
    }

    protected function makeAuthClaims($device)
    {
        return [
            'id' => $device->id,
            'name' => $device->name,
            $this->identify() => $device->{$this->identify()},
            'guard' => $this->getGuard(),
            'store_id' => $device->store_id,
        ];
    }
}
