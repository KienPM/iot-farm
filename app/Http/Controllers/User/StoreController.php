<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Http\Controllers\Core\StoreController as BaseController;

class StoreController extends BaseController
{
    protected $guard = 'user';

    public function __construct()
    {
        $this->middleware($this->authMiddleware())->except(['index', 'show']);
    }
}
