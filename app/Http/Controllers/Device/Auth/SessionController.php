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
}
