<?php

namespace App\Http\Controllers\Sensor\Auth;

use App\Http\Controllers\Core\Auth\SessionController as BaseSessionController;

class SessionController extends BaseSessionController
{
    protected $guard = 'sensor';

    protected function identify()
    {
        return 'identify_code';
    }
}
