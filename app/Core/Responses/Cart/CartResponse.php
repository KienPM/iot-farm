<?php

namespace App\Core\Responses\Cart;

use App\Core\Responses\Response;

class CartResponse extends Response
{
    public static function showCartResponse($status, $data = null)
    {
        return self::response(
            config('status.' . $status),
            '',
            $data
        );
    }

    public static function addItemResponse($status, $data = null, $message = '')
    {
        if (!$message) {
            $message = trans('response.add_' . $status, ['name' => trans('name.item')]);
        }

        return self::response(
            config('status.' . $status),
            $message,
            $data
        );
    }

    public static function updateItemResponse($status, $data = null, $message = '')
    {
        if (!$message) {
            $message = trans('response.update_' . $status, ['name' => trans('name.item')]);
        }

        return self::response(
            config('status.' . $status),
            $message,
            $data
        );
    }

    public static function deleteItemsResponse($status, $data = null, $message = '')
    {
        if (!$message) {
            $message = trans('response.delete_' . $status, ['name' => trans('name.item')]);
        }

        return self::response(
            config('status.' . $status),
            $message,
            $data
        );
    }

    public static function checkOutResponse($status, $message = '', $data = null)
    {
        if (!$message) {
            $message = trans('response.checkout_' . $status);
        }

        return self::response(config('status.' . $status), $message, $data);
    }

}
