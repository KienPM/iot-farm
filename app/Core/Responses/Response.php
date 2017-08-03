<?php

namespace App\Core\Responses;

class Response
{
    public static function response($status, $message = '', $data = null, $code = 200)
    {
        $result = ['status' => $status];
        if (!empty($message)) {
            $result['message'] = $message;
        }

        if ($data !== null) {
            $result = array_merge($result, $data);
        }

        return response()->json($result, $code);
    }

    public static function responseWithToken($status, $message = '', $data = null, $code = 200)
    {
        $result = [
            'status' => $status,
            'token' => csrf_token(),
        ];

        if (!empty($message)) {
            $result['message'] = $message;
        }

        if ($data !== null) {
            $result['data'] = $data;
        }

        return response()->json($result, $code);
    }

    public static function cantContinue()
    {
        return self::response(config('status.error'), trans('response.can_not_continue_request'), null, 400);
    }

    public static function tokenMismatchException()
    {
        return self::responseWithToken(config('status.error'), trans('response.token_mismatch'), null, 400);
    }

    public static function notFoundHttpException()
    {
        return self::response(config('status.warning'), trans('response.not_found'), null, 404);
    }

    public static function methodNotAllowedHttpException()
    {
        return self::response(config('status.error'), trans('response.method_not_allowed'), null, 404);
    }

    public static function unauthenticated()
    {
        return self::response(config('status.error'), trans('response.unauthenticated'), null, 401);
    }
}
