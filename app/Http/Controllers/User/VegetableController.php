<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Core\VegetableController as BaseController;

class VegetableController extends BaseController
{
    protected $guard = 'user';

    public function __construct()
    {
    }
}
