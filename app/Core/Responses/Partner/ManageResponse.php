<?php

namespace App\Core\Responses\Partner;

use App\Core\Responses\ManageResponse as BaseResponse;

class ManageResponse extends BaseResponse
{
    public static function listPartnerResponse($status, $data = null)
    {
        return self::basicResponse(
            'list',
            'partner',
            $status,
            $data
        );
    }

    public static function showPartnerResponse($status, $data = null)
    {
        return self::basicResponse(
            'show',
            'partner',
            $status,
            $data
        );
    }

    public static function createPartnerResponse($status, $data = null)
    {
        return self::basicResponse(
            'create',
            'partner',
            $status,
            $data
        );
    }

    public static function updatePartnerResponse($status, $data = null)
    {
        return self::basicResponse(
            'update',
            'partner',
            $status,
            $data
        );
    }
}
