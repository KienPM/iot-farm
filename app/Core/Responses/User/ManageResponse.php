<?php

namespace App\Core\Responses\User;

use App\Core\Responses\ManageResponse as BaseResponse;

class ManageResponse extends BaseResponse
{
    public static function listUserResponse($status, $data = null)
    {
        return self::basicResponse(
            'list',
            'user',
            $status,
            $data
        );
    }

    public static function showUserResponse($status, $data = null)
    {
        return self::basicResponse(
            'show',
            'user',
            $status,
            $data
        );
    }

    public static function createUserResponse($status, $data = null)
    {
        return self::basicResponse(
            'create',
            'user',
            $status,
            $data
        );
    }

    public static function updateUserResponse($status, $data = null)
    {
        return self::basicResponse(
            'update',
            'user',
            $status,
            $data
        );
    }
}
