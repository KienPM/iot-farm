<?php

namespace App\Core\Responses\Store;

use App\Core\Responses\ManageResponse as BaseResponse;

class ManageResponse extends BaseResponse
{
    public static function createStoreResponse($status, $data = null)
    {
        return self::basicResponse(
            'create',
            'store',
            $status,
            $data
        );
    }

    public static function updateStoreResponse($status, $data = null)
    {
        return self::basicResponse(
            'update',
            'store',
            $status,
            $data
        );
    }
}
