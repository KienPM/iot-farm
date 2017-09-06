<?php

namespace App\Core\Responses\Cart;

use App\Core\Responses\Response;

class OrderResponse extends Response
{
    public static function listOrderResponse($status, $data = null)
    {
        return self::basicResponse(
            'list',
            'order',
            $status,
            $data
        );
    }

    public static function showOrderResponse($status, $message = '', $data = null)
    {
        if (!$message) {
            $message = trans('message.not_found', ['name' => studly_case(trans('order'))]);
        }
        return self::response(
            config('status.' . $status),
            $message,
            $data
        );
    }
}
