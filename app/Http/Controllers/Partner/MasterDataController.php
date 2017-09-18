<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Core\MasterDataController as BaseController;

class MasterDataController extends BaseController
{
    protected $guard = 'partner';
    protected $dataTypeActive = ['vegetable'];
}
