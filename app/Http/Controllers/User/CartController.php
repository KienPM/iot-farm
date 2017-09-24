<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Responses\Cart\CartResponse;
use App\Models\CartItem;
use App\Models\VegetableInStore;
use App\Models\Order;
use App\Models\User;
use App\Models\Store;
use App\Http\Requests\Cart\AddItemRequest;
use App\Http\Requests\Cart\UpdateItemRequest;
use App\Http\Requests\Cart\DeleteItemRequest;
use Exception;
use App\Services\NganLuongCheckout;
use DB;

class CartController extends Controller
{
    protected $guard = 'user';

    public function __construct()
    {
        $this->middleware($this->authMiddleware())->except('checkoutReturn', 'checkoutCancel');
    }

    public function index(Request $request)
    {
        $itemPerPage = $request->get('items_per_page', CartItem::ITEMS_PER_PAGE);
        $user = $request->user();
        $data = $this->getCartItemsWithRelation($user, $itemPerPage);
        return CartResponse::showCartResponse('success', $data);
    }

    public function deleteAll(Request $request)
    {
        $itemPerPage = $request->get('items_per_page', CartItem::ITEMS_PER_PAGE);
        $user = $request->user();
        try {
            $items = $user->cartItems()->delete();
            $data = $this->getCartItemsWithRelation($user, $itemPerPage);
            return CartResponse::deleteItemsResponse('success', $data);
        } catch (Exception $e) {
            $data = $this->getCartItemsWithRelation($user, $itemPerPage);
            return CartResponse::deleteItemsResponse('error', $data, $e->getMessage());
        }
    }

    public function checkout(Request $request)
    {
        try {

            DB::beginTransaction();
            $user = $request->user();
            $items = $user->checkedItems()->with('vegetableInStore.vegetable')->get();

            //Mã đơn hàng
            $orderCode = $this->generateOrderCode();

            $orderInfo = $this->generateOrderInfo($items);
            $order = $this->addOrderAndItems($user, $orderCode, $orderInfo);
            // $this->removeCartItems($items);

            $returnUrl = url(config('order.return_url') . '/' . $order->id);
            $cancelUrl = url(config('order.cancel_url') . '/' . $order->id);

            // Thong tin khach hang
            $name = $user->name;
            $email = $user->email;
            $phone = $user->phone_number;
            $addr = '';

            //Thông tin giao dịch

            $transactionInfo = 'Thong tin giao dich';
            $currency = 'vnd';
            $quantity = 1;
            $tax = 0;
            $discount = 0;
            $feeCal = 0;
            $feeShipping = 0;
            $orderDescription = $orderInfo['description'];
            $buyerInfo = $name . '*|*' . $email . '*|*' . $phone . '*|*' . $addr;

            $nl = new NganLuongCheckout;
            $url = $nl->buildCheckoutUrlExpand(
                $returnUrl,
                $transactionInfo,
                $orderCode,
                $orderInfo['total_price'],
                // 2000,
                $currency,
                $quantity,
                $tax,
                $discount ,
                $feeCal,
                $feeShipping,
                $orderDescription,
                $buyerInfo
            );
            $url .= '&cancel_url=' . $cancelUrl;

            DB::commit();
            return redirect($url);
        } catch (Exception $e) {
            DB::rollBack();
            return CartResponse::checkOutResponse('error', $e->getMessage());
        }
    }

    public function checkoutReturn(Order $order, Request $request)
    {
        $user = $request->user();
        try {
            if ($order->user_id != $user->id || $order->status > 1) {
                throw new Exception(trans('message.not_found', ['name' => studly_case(trans('order'))]));
            }

            $order->update([
                'status' => Order::ORDER_PROCESSING,
            ]);
            $items = $user->checkedItems()->with('vegetableInStore.vegetable')->get();
            $this->removeCartItems($items);

            return view('checkout.success', ['order' => $order->load('items.vegetablesInStore.vegetable')->toArray()]);
            // return CartResponse::checkOutResponse(
            //     'success',
            //     trans('response.checkout_success', ['orderId' => $order->code]),
            //     [
            //         'data' => $order->toArray(),
            //     ]
            // );
        } catch (Exception $e) {
            return CartResponse::checkOutResponse('error', $e->getMessage());
        }
    }

    public function checkoutCancel(Order $order, Request $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user();
            if ($order->user_id != $user->id || $order->status > 1) {
                throw new Exception(trans('message.not_found', ['name' => studly_case(trans('order'))]));
            }
            $items = $order->items()->get();
            $this->addCartItems($user, $items);
            $this->removeOrderAndItems($order);
            DB::commit();
            return view('checkout.cancel');

            // return CartResponse::checkOutResponse('warning', trans('response.checkout_cancel'));
        } catch (Exception $e) {
            DB::rollBack();
            return CartResponse::checkOutResponse('error', $e->getMessage());
        }
    }

    public function addItem(AddItemRequest $request)
    {
        $itemPerPage = $request->get('items_per_page', CartItem::ITEMS_PER_PAGE);
        $user = $request->user();
        try {
            $vegetables = collect($request->get('vegetables'));
            $vegetableIds = $vegetables->pluck('id');
            $storeId = $request->get('store_id');
            $vegetablesInStore = VegetableInStore::whereIn('vegetable_id', $vegetableIds)
                ->where('store_id', $storeId)
                ->get();

            if ($vegetablesInStore->isEmpty()) {
                throw new Exception(trans('message.not_found', ['name' => studly_case(trans('name.vegetable'))]));
            }
            foreach ($vegetablesInStore as $vegetableInStore) {
                $quantity = $this->getItemQuantity($vegetableInStore->vegetable_id, $vegetables);
                $this->addOrUpdateCartItem($user, $vegetableInStore->id, $quantity);
            }

            $data = $this->getCartItemsWithRelation($user, $itemPerPage);
            return CartResponse::addItemResponse('success', $data);
        } catch (Exception $e) {
            $data = $this->getCartItemsWithRelation($user, $itemPerPage);
            return CartResponse::addItemResponse('error', $data, $e->getMessage());
        }
    }

    protected function addOrUpdateCartItem($user, $vegetableInStoreId, $quantity = 1)
    {
        $cartItem = $user->cartItems()
            ->where('vegetable_in_store_id', $vegetableInStoreId)
            ->first();
        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity,
            ]);
        } else {
            $user->cartItems()->create([
                'vegetable_in_store_id' => $vegetableInStoreId,
                'quantity' => $quantity,
            ]);
        }
    }

    protected function getItemQuantity($id, $vegetables)
    {
        foreach ($vegetables as $vegetable) {
            if ($vegetable['id'] == $id) {
                if (isset($vegetable['quantity'])) {
                    return $vegetable['quantity'];
                }

                return 1;
            }
        }

        return 1;
    }

    public function updateItem(CartItem $item, UpdateItemRequest $request)
    {
        $itemPerPage = $request->get('items_per_page', CartItem::ITEMS_PER_PAGE);
        $user = $request->user();
        try {
            if ($user->id != $item->user_id) {
                return CartResponse::cantContinue();
            }

            $quantity = $request->get('quantity');
            $checked = $request->get('checked');
            $updateData = [];
            if ($quantity) {
                $updateData['quantity'] = $quantity;
            }

            if ($checked !== null) {
                $updateData['checked'] = $checked;
            }

            $item->update($updateData);

            $data = $this->getCartItemsWithRelation($user, $itemPerPage);
            return CartResponse::updateItemResponse('success', $data);
        } catch (Exception $e) {
            $data = $this->getCartItemsWithRelation($user, $itemPerPage);
            return CartResponse::updateItemResponse('error', $data, $e->getMessage());
        }
    }

    public function deleteItems(DeleteItemRequest $request)
    {
        $itemPerPage = $request->get('items_per_page', CartItem::ITEMS_PER_PAGE);
        $user = $request->user();
        try {
            $itemsIsDelete = $request->get('items');
            if (!$itemsIsDelete) {
                throw new Exception(trans('message.not_found', ['name' => studly_case(trans('name.item'))]));
            }
            $user->cartItems()
                ->whereIn('id', $itemsIsDelete)
                ->delete();

            $data = $this->getCartItemsWithRelation($user, $itemPerPage);
            return CartResponse::deleteItemsResponse('success', $data);
        } catch (Exception $e) {
            $data = $this->getCartItemsWithRelation($user, $itemPerPage);
            return CartResponse::deleteItemsResponse('error', $data, $e->getMessage());
        }
    }

    protected function getCartItemsWithRelation($user, $itemPerPage = CartItem::ITEMS_PER_PAGE)
    {
        $items = $user->cartItems()->with('vegetableInStore.vegetable.images')->paginate($itemPerPage)->toArray();
        $items['data'] = collect($items['data'])->transform(function ($item) {
            if (empty($item['vegetable_in_store']['vegetable']['images'])) {
                $images[] = url('public/' . config('upload.path.default') . '/' . config('upload.default.vegetable_image'));
            } else {
                $images = collect($item['vegetable_in_store']['vegetable']['images'])->transform(function ($image) {
                    return url($image['src']);
                })->toArray();
            }
            $item['vegetable_in_store']['vegetable']['images'] = $images;
            return $item;
        })->toArray();

        if (empty($items['data'])) {
            $items['store'] = null;
        } else {
            $items['store'] = Store::select(['id', 'logo', 'name', 'address', 'phone_number', 'longitude', 'latitude'])
                ->where('id', $items['data'][0]['vegetable_in_store']['store_id'])
                ->first();
        }

        return $items;
    }

    protected function generateOrderInfo($items)
    {
        $totalPrice = 0;
        $orderDescription = '';
        $orderItems = [];
        if ($items->isEmpty()) {
            throw new Exception(trans('message.cart_is_empty'));
        }

        foreach ($items as $item) {
            $price = $item->quantity * $item->vegetableInStore->price;
            $totalPrice += $price;
            $orderDescription .= $item->quantity . '*';
            $orderDescription .= $item->vegetableInStore->vegetable->name . ' ';
            $orderDescription .= number_format($price , 0, ',', '.') . ' vnd, ';
            $orderItems[] = [
                'vegetable_in_store_id' => $item->vegetable_in_store_id,
                'quantity' => $item->quantity,
            ];
        }

        if ($totalPrice < 2) {
            throw new Exception(trans('message.small_money'));
        }

        return [
            'total_price' => $totalPrice,
            'description' => trim($orderDescription, ', '),
            'order_items' => $orderItems,
        ];
    }

    protected function addOrderAndItems($user, $orderCode, $orderInfo)
    {
        $order = $user->orders()->create([
            'code' => $orderCode,
            'total_price' => $orderInfo['total_price'],
            'status' => Order::ORDER_SUBMITED,
        ]);

        $order->items()->createMany($orderInfo['order_items']);

        return $order;
    }

    protected function addCartItems(User $user, $items)
    {
        $items = $items->map(function ($item) {
            $this->addOrUpdateCartItem($user, $item['vegetable_in_store_id'], $item['quantity']);
        });
    }

    protected function removeOrderAndItems(Order $order)
    {
        $order->items()->delete();
        $order->delete();
    }

    protected function removeCartItems($items)
    {
        return CartItem::whereIn('id', $items->pluck('id')->toArray())->delete();
    }

    protected function generateOrderCode()
    {
        return config('order.prefix') . time() . str_random(3);
    }
}
