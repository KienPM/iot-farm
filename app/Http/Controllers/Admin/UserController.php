<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Core\QueryFilter\UserFilter;
use App\Core\Responses\User\ManageResponse;
// use App\Http\Controllers\Core\Traits\PartnerManageTrait;

class UserController extends Controller
{
    protected $guard = 'admin';

    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    public function index(Request $request, UserFilter $query)
    {
        try {
            $itemPerPage = $request->get('items_per_page', User::ITEMS_PER_PAGE);
            $users = User::filterBy($query)->paginate($itemPerPage)->toArray();

            return ManageResponse::listUserResponse('success', $users);
        } catch (Exception $e) {
            return ManageResponse::listUserResponse('error');
        }
    }
}
