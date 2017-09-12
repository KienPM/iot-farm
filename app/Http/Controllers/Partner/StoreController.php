<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Core\StoreController as BaseController;
use App\Models\Store;
use Exception;
use App\Http\Controllers\Core\Contracts\StoreManageContract;
use App\Http\Controllers\Core\Traits\StoreManageTrait;
use App\Core\QueryFilter\StoreFilter;
use App\Core\Responses\ManageResponse;
use Auth;

class StoreController extends BaseController implements StoreManageContract
{
    use StoreManageTrait;

    protected $guard = 'partner';
    protected $updateFields = ['info'];

    protected function validateUpdateRequest($request, $store)
    {
        if ($request->user()->id !== $store->partner_id) {
            return ManageResponse::cantContinue();
        }

        $updateRules = [
            'info' => 'max:50000',
        ];

        return $this->validate($request, $updateRules);
    }

    public function index(Request $request, StoreFilter $query)
    {
        $user = $request->user();
        $itemPerPage = $request->get('items_per_page', Store::ITEMS_PER_PAGE);
        $stores = Store::filterBy($query)->where('partner_id', $user->id)->paginate($itemPerPage);
        return ManageResponse::response(
            'success',
            trans('response.list_success', ['name' => trans('name.store')]),
            $stores->toArray()
        );
    }

    public function show(Store $store, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $store->partner_id) {
            return ManageResponse::cantContinue();
        }

        return ManageResponse::response(
            'success',
            trans('response.list_success', ['name' => trans('name.store')]),
            $store->load(['vegetables'])->toArray()
        );
    }

    public function devices(Store $store, Request $request)
    {
        if ($request->user()->id !== $store->partner_id) {
            return ManageResponse::cantContinue();
        }

        return ManageResponse::response(
            'success',
            config('response.get_store_detail_success'),
            ['data' => $store->load([
                'devices' => function ($query) {
                    $query->with([
                        'category' => function ($q) {
                            $q->select(['id', 'name', 'symbol']);
                        }
                    ]);
                }
            ])]
        );
    }
}
