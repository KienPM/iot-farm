<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Core\Traits\UserNormalTrait;
use App\Http\Controllers\Core\Auth\SessionController as BaseSessionController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use App\Models\User;
use App\Models\SocialUser;
use Auth;
use Exception;
use App\Core\Responses\Auth\AuthResponse;
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

            if (!$this->attemptLogin($request, $credentials)) {
                throw new Exception('Can not login!');
            }

            DB::commit();
            return $this->userWasAuthenticated($auth);
        } catch (Exception $e) {
            DB::rollBack();
            return AuthResponse::registerFailedResponse();
        }
    }

    public function login(Request $request, JWTAuth $auth)
    {
        $this->validateLogin($request);

        try {
            DB::beginTransaction();
            $provider = $this->checkProvider($request);

            if ($provider) {
                $user = $this->getUserFromSocialUser($request->only(['email', 'name', 'provider', 'provider_user_token']));
                Auth::guard($this->guard)->login($user, true);
            } else {
                $credentials = $request->only(['email', 'password']);
                if (!$this->attemptLogin($request, $credentials)) {
                    throw new Exception();
                }
            }
            DB::commit();

            return $this->userWasAuthenticated($auth);
        } catch (Exception $e) {
            DB::rollBack();

            return AuthResponse::loginFailedResponse();
        }

    }

    protected function getUserFromSocialUser($socialData)
    {
        $social = SocialUser::where('provider', $socialData['provider'])
            ->where('provider_user_token', $socialData['provider_user_token'])
            ->first();

        if ($social) {
            $user = $social->user()->first();
        } else {
            if (!empty($socialData['email'])) {
                $user = User::where('email', $socialData['email'])->first();

                if ($user) {
                    $this->createSocial($user, $socialData);
                    return $user;
                }
            }

            $user = User::create([
                'name' => $socialData['name'],
                'email' => $socialData['email'] ? $socialData['email'] : uniqid(),
                'password' => uniqid(),
                'is_actived' => true,
            ]);
            $this->createSocial($user, $socialData);
        }

        return $user;
    }

    protected function createSocial($user, $socialData)
    {
        return $user->socialUsers()->create([
            'provider' => $socialData['provider'],
            'provider_user_token' => $socialData['provider_user_token'],
        ]);
    }

    protected function checkProvider($request)
    {
        $provider = $request->get('provider');
        if (empty($provider)) {
            return false;
        }

        if (array_key_exists($provider, SocialUser::AVAILABLE_SOCIAL_PROVIDER)) {
            return $provider;
        }

        return false;
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|string',
            'password' => 'required_without:name,provider,provider_user_token|string',
            'name' => 'required_with:provider,provider_user_token|string',
            'provider' => 'required_with:name,provider_user_token|string',
            'provider_user_token' => 'required_with:name,provider|string',
        ]);
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

    protected function validateRegisterRequest($request)
    {
        $registerRule = [
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'phone_number' => 'numeric',
        ];

        return $this->validate($request, $registerRule);
    }
}
