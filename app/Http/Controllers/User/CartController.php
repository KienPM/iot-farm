<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Responses\Cart\CartResponse;
use App\Models\CartItem;
use App\Http\Requests\Cart\AddItemRequest;
use App\Http\Requests\Cart\UpdateItemRequest;
use App\Http\Requests\Cart\DeleteItemRequest;
use Exception;

class CartController extends Controller
{
    protected $guard = 'user';

    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    public function index(Request $request)
    {
        $itemPerPage = $request->get('items_per_page', CartItem::ITEMS_PER_PAGE);
        $user = $request->user();
        $data = $this->getCartItemsWithRelation($user, $itemPerPage);
        return CartResponse::showCartResponse('success', $data);
    }

    public function addItem(AddItemRequest $request)
    {
        $itemPerPage = $request->get('items_per_page', CartItem::ITEMS_PER_PAGE);
        try {
            $vegetableInStoreId = $request->get('vegetable_in_store_id');
            $quantity = $request->get('quantity');
            $user = $request->user();
            $cartItems = $user->cartItems()
                ->where('vegetable_in_store_id', $vegetableInStoreId)
                ->get();
            if ($cartItems->isEmpty()) {
                $user->cartItems()->create([
                    'vegetable_in_store_id' => $vegetableInStoreId,
                    'quantity' => $quantity ? $quantity : 1,
                ]);
            } else {
                $cartItems[0]->update([
                    'quantity' => $cartItems[0]->quantity + $quantity,
                ]);
            }

            $data = $this->getCartItemsWithRelation($user, $itemPerPage);
            return CartResponse::addItemResponse('success', $data);
        } catch (Exception $e) {
            $data = $this->getCartItemsWithRelation($user, $itemPerPage);
            return CartResponse::addItemResponse('error', $data);
        }
    }

    public function updateItem(CartItem $item, UpdateItemRequest $request)
    {
        $itemPerPage = $request->get('items_per_page', CartItem::ITEMS_PER_PAGE);
        try {
            if ($request->user()->id != $item->user_id) {
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
        try {
            $itemsIsDelete = $request->get('items');
            $user = $request->user();
            $user->cartItems()
                ->whereIn('vegetable_in_store_id', $itemsIsDelete)
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
        return $user->cartItems()->with('vegetableInStore.vegetable.images')->paginate($itemPerPage)->toArray();
    }
}
