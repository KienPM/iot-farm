<?php

namespace App\Http\Controllers\Core\Auth;

use App;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;
use App\Core\Responses\Auth\AuthResponse;

abstract class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'index']]);
    }

    abstract protected function identify();

    public function index(JWTAuth $auth)
    {
        if (Auth::guard($this->getGuard())->check()) {
            return $this->userWasAuthenticated($auth);
        }

        return AuthResponse::notLoginResponse();
    }

    public function login(Request $request, JWTAuth $auth)
    {
        $this->validateLogin($request);
        $credentials = $this->getCredentials($request);

        if ($this->attemptLogin($request, $credentials)) {
            return $this->userWasAuthenticated($auth);
        }

        return AuthResponse::loginFailedResponse();
    }

    public function logout()
    {
        Auth::guard($this->getGuard())->logout();

        return AuthResponse::notLoginResponse();
    }

    protected function attemptLogin(Request $request, $credentials)
    {
        return Auth::guard($this->getGuard())->attempt($credentials, true);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->identify() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function getCredentials(Request $request)
    {
        return $request->only($this->identify(), 'password');
    }


    protected function userWasAuthenticated($auth)
    {
        $guard = $this->getGuard();
        $user = Auth::guard($guard)->user();
        if ($user->isActive()) {
            $claims = $this->makeAuthClaims($user);
            $authToken = $auth->fromUser($user, $claims);
            $result = $this->makeUserResult($user, $authToken);

            return AuthResponse::loginSuccessResponse($result);
        }

        $this->logout();
        return AuthResponse::userNotActiveResponse();
    }

    protected function makeAuthClaims($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            $this->identify() => $user->{$this->identify()},
            'guard' => $this->getGuard(),
        ];
    }

    protected function makeUserResult($user, $authToken)
    {
        return [
            'user' => $user->toArray(),
            'auth_token' => $authToken,
        ];
    }

    protected function responseNotLogin()
    {
        return $this->response([
            'status' => 'not_login',
            'message' => trans('auth.not_login')
        ], 401);
    }

    protected function responseToFailedLogin()
    {
        return $this->response([
            'status' => 'not_login',
            'message' => trans('auth.failed')
        ], 401);
    }
}
