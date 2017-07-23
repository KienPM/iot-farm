<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Core\Auth\PasswordController as BasePasswordController;

class PasswordController extends BasePasswordController
{
    protected $guard = 'user';
    protected $broker = 'users';
}
