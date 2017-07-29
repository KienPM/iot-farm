<?php

namespace App\Http\Controllers\Core\Auth;

use App;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;

abstract class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'index']]);
    }

    public function index(JWTAuth $auth)
    {
        if (Auth::guard($this->getGuard())->check()) {
            return $this->userWasAuthenticated($auth);
        }

        return $this->responseNotLogin();
    }

    public function login(Request $request, JWTAuth $auth)
    {
        $this->validateLogin($request);
        $credentials = $this->getCredentials($request);

        if ($this->attemptLogin($request, $credentials)) {
            return $this->userWasAuthenticated($auth);
        }

        return $this->responseToFailedLogin();
    }

    public function logout()
    {
        Auth::guard($this->getGuard())->logout();

        return $this->responseNotLogin();
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

    abstract protected function identify();

    protected function userWasAuthenticated($auth)
    {
        $result = [];
        $guard = $this->getGuard();
        $user = Auth::guard($guard)->user();
        $claims = [
            'name' => $user->name,
            $this->identify() => $user->{$this->identify()},
            'guard' => $guard,
        ];

        $authToken = $auth->fromUser($user, $claims);
        $result['user'] = $user->toArray();
        $result['auth_token'] = $authToken;
        $result['status'] = 'logined';

        return $this->response($result);
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
