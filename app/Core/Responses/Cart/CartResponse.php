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

    public static function addItemResponse($status, $data = null)
    {
        return self::response(
            config('status.' . $status),
            trans('response.add_' . $status, [
                'item' => trans('name.item'),
                'cart' => trans('name.cart'),
            ]),
            $data
        );
    }

    public static function updateItemResponse($status, $data = null, $message = '')
    {
        if ($message) {
            $message = trans('response.update_' . $status, ['name' => trans('name.item')]);
        }

        return self::response(
            config('status.' . $status),
            $message,
            $data
        );
    }

    public static function deleteItemsResponse()
    {
        if ($message) {
            $message = trans('response.delete_' . $status, ['name' => trans('name.item')]);
        }

        return self::response(
            config('status.' . $status),
            $message,
            $data
        );
    }

}
