<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\MasterDataController as BaseController;

class MasterDataController extends BaseController
{
    protected $guard = 'admin';
    protected $dataTypeActive = ['vegetables'];
}
