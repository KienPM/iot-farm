<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Http\Controllers\Core\StoreController as BaseController;
use DB;
use App\Core\QueryFilter\StoreFilter;
use App\Core\Responses\Store\ManageResponse;
use Exception;

class StoreController extends BaseController
{
    protected $guard = 'user';

    public function __construct()
    {
        $this->middleware($this->authMiddleware())->except(['index', 'show', 'search']);
    }

    public function index(Request $request, StoreFilter $query)
    {
        $this->validateSearchRequest($request);

        try {
            $vegetables = $request->get('vegetables', []);
            $vegetables = array_unique($vegetables);
            $stores = Store::filterBy($query);

            foreach ($vegetables as $vegetableId) {
                $stores = $stores->whereHas('vegetablesInStore', function ($query) use ($vegetableId) {
                    $query->where('vegetable_id', $vegetableId);
                });
            }

            $stores = $stores->with(['partner', 'images']);

            $all = $request->get('all', 0);
            if ($all) {
                $stores = [
                    'data' => $stores->get()->toArray(),
                ];
            } else {
                $itemPerPage = $request->get('items_per_page', Store::ITEMS_SEARCH_PER_PAGE);
                $stores = $stores->paginate($itemPerPage)->toArray();
            }

            $latitude = $request->get('latitude', null);
            $longitude = $request->get('longitude', null);
            // dd($latitude, $longitude);

            if ($latitude !== null && $longitude !== null) {
                $stores['data'] = $this->orderByDistance($stores['data'], $latitude, $longitude);
            }

            return ManageResponse::listStoreResponse('success', $stores);
        } catch (Exception $e) {
            return ManageResponse::listStoreResponse('error');
        }
    }

    protected function validateSearchRequest(Request $request)
    {
        $rules = [
            'vegetables' => 'array',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
        ];

        $this->validate($request, $rules);
    }
}
