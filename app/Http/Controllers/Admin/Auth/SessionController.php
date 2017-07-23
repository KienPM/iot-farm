<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Core\Auth\SessionController as BaseSessionController;
use App\Http\Controllers\Core\Traits\UserNormalTrait;

class SessionController extends BaseSessionController
{
    use UserNormalTrait;

    protected $guard = 'admin';
}
