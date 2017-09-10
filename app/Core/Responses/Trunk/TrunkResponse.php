<?php

namespace App\Core\Responses\Trunk;

use App\Core\Responses\ManageResponse as BaseResponse;

class TrunkResponse extends BaseResponse
{
    public static function listTrunkResponse($status, $data = null)
    {
        return self::basicResponse(
            'list',
            'trunk',
            $status,
            $data
        );
    }

    public static function showTrunkResponse($status, $data = null)
    {
        return self::basicResponse(
            'show',
            'trunk',
            $status,
            $data
        );
    }

    public static function createTrunkResponse($status, $data = null)
    {
        return self::basicResponse(
            'create',
            'trunk',
            $status,
            $data
        );
    }

    public static function updateTrunkResponse($status, $data = null)
    {
        return self::basicResponse(
            'update',
            'trunk',
            $status,
            $data
        );
    }

    public static function deleteTrunkResponse($status)
    {
        return self::basicResponse(
            'delete',
            'trunk',
            $status
        );
    }
}
