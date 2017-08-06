<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Core\Traits\UserNormalTrait;
use App\Http\Controllers\Core\Auth\SessionController as BaseSessionController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use App\Models\User;
use Auth;
use DB;

class SessionController extends BaseSessionController
{
    use UserNormalTrait;

    protected $guard = 'user';

    public function register(Request $request, JWTAuth $auth)
    {
        $this->validateRegisterRequest($request);

        try {
            DB::beginTransaction();
            $newUser = $request->only(['name', 'email', 'password', 'phone_number']);
            $newUser['password'] = bcrypt($newUser['password']);

            $user = User::create($newUser);
            $credentials = $this->getCredentials($request);

            if ($this->attemptLogin($request, $credentials)) {
                return $this->userWasAuthenticated($auth);
            }

            DB::commit();
            return $this->userWasAuthenticated($auth);
        } catch (Exception $e) {
            DB::rollBack();
            return AuthResponse::registerFailedResponse();
        }
    }

    protected function validateRegisterRequest($request)
    {
        $registerRule = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'phone_number' => 'numeric',
        ];

        return $this->validate($request, $registerRule);
    }
}
