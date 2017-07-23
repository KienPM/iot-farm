<?php

namespace App\Http\Controllers\Partner\Auth;

use App\Http\Controllers\Core\Traits\UserNormalTrait;
use App\Http\Controllers\Core\Auth\SessionController as BaseSessionController;

class SessionController extends BaseSessionController
{
    use UserNormalTrait;

    protected $guard = 'partner';
}
