<?php

namespace App\Http\Controllers\Parter\Auth;

use App\Http\Controllers\Core\Auth\PasswordController as BasePasswordController;

class PasswordController extends BasePasswordController
{
    protected $guard = 'partner';
    protected $broker = 'partners';
}
