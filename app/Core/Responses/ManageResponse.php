<?php

namespace App\Core\Responses;

class ManageResponse extends Response
{
    public static function createResponse($name, $status, $data = null)
    {
        return self::basicResponse(
            'create',
            $name,
            $status,
            $data
        );
    }

    public static function updateResponse($name, $status, $data = null)
    {
        return self::basicResponse(
            'update',
            $name,
            $status,
            $data
        );
    }
}
