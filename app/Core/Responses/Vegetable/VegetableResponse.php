<?php

namespace App\Core\Responses\Vegetable;

use App\Core\Responses\ManageResponse as BaseResponse;

class VegetableResponse extends BaseResponse
{
    public static function listVegetableResponse($status, $data = null, $message = '')
    {
        return self::basicResponse(
            'list',
            'vegetable',
            $status,
            $data,
            $message
        );
    }

    public static function showVegetableResponse($status, $data = null, $message = '')
    {
        return self::basicResponse(
            'show',
            'vegetable',
            $status,
            $data,
            $message
        );
    }

    public static function createVegetableResponse($status, $data = null, $message = '')
    {
        return self::basicResponse(
            'create',
            'vegetable',
            $status,
            $data,
            $message
        );
    }

    public static function updateVegetableResponse($status, $data = null, $message = '')
    {
        return self::basicResponse(
            'update',
            'vegetable',
            $status,
            $data,
            $message
        );
    }

    public static function deleteVegetableResponse($status, $message = '')
    {
        return self::basicResponse(
            'delete',
            'vegetable',
            $status,
            null,
            $message
        );
    }
}
