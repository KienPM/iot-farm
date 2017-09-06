<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Responses\Cart\OrderResponse;
use App\Models\Order;
use Exception;

class OrderController extends Controller
{
    protected $guard = 'user';

    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    public function index(Request $request)
    {
        $itemPerPage = $request->get('items_per_page', Order::ITEMS_PER_PAGE);
        try {
            $user = $request->user();
            return OrderResponse::listOrderResponse(
                'success',
                $user->orders()->with('items.vegetablesInStore.vegetable')->paginate($itemPerPage)->toArray()
            );
        } catch (Exception $e) {
            return OrderResponse::listOrderResponse('error');
        }
    }

    public function show(Order $order, Request $request)
    {
        try {
            $user = $request->user();

            if ($user->id !== $order->user_id) {
                throw new Exception(trans('message.not_found', ['name' => studly_case(trans('order'))]));
            }

            return OrderResponse::showOrderResponse(
                'success',
                trans('response.show_success', ['name' => studly_case(trans('order'))]),
                $order->load('items.vegetablesInStore.vegetable.images')->toArray()
            );
        } catch (Exception $e) {
            return OrderResponse::showOrderResponse('error', $e->getMessage());
        }
    }
}
