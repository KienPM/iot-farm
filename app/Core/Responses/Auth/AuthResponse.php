<?php

namespace App\Core\Responses\Auth;

use App\Core\Responses\Response;

class AuthResponse extends Response
{
    public static function notLoginResponse($data = null)
    {
        return static::responseWithToken(
            config('status.warning'),
            trans('auth.not_login'),
            $data,
            401
        );
    }

    public static function loginFailedResponse($data = null)
    {
        return static::responseWithToken(
            config('status.error'),
            trans('auth.failed'),
            $data,
            401
        );
    }

    public static function userNotActiveResponse($data = null)
    {
        return static::responseWithToken(
            config('status.error'),
            trans('auth.not_actived'),
            $data,
            401
        );
    }

    public static function loginSuccessResponse($data = null)
    {
        if ($data && $data['guard'] == 'device') {
            return [
                'status' => 'success',
                'data' => $data,
            ];
        }
        return static::responseWithToken(
            config('status.success'),
            trans('auth.login_success'),
            $data
        );
    }

    public function registerFailedResponse($data = null)
    {
        return static::responseWithToken(
            config('status.error'),
            trans('auth.register_error'),
            $data
        );
    }
}
