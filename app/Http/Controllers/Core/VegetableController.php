<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Request;
use App\Models\Vegetable;
use App\Core\QueryFilter\VegetableFilter;
use App\Core\Responses\Vegetable\VegetableResponse;
use App\Http\Controllers\Controller;
use DB;

abstract class VegetableController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    public function index(Request $request, VegetableFilter $query)
    {
        try {
            $all = $request->get('all', 0);

            if ($all) {
                $vegetables = [
                    'data' => Vegetable::filterBy($query)
                        ->with(['images'])
                        ->get()
                        ->toArray(),
                ];
            } else {
                $itemPerPage = $request->get('items_per_page', Vegetable::ITEMS_PER_PAGE);
                $vegetables = Vegetable::filterBy($query)
                    ->with(['images'])
                    ->paginate($itemPerPage)
                    ->toArray();
            }
            return VegetableResponse::listVegetableResponse('success', $vegetables);
        } catch (Exception $e) {
            return VegetableResponse::listVegetableResponse('error', null, $e->getMessage());
        }
    }
}
