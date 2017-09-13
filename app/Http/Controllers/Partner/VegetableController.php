<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Models\Vegetable;
use App\Core\Uploader\VegetableImageUploader;
use App\Core\QueryFilter\VegetableFilter;
use App\Core\Responses\Vegetable\VegetableResponse;
use App\Http\Controllers\Controller;
use DB;

class VegetableController extends Controller
{
    protected $guard = 'partner';

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
                    'data' => Vegetable::with(['images'])
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

            $vegetables['data'] = collect($vegetables['data'])->map(function ($vegetable) {
                $vegetable['image'] = empty($vegetable['images']) ? null : $vegetable['images'][0];
                unset($vegetable['images']);
                return $vegetable;
            })->toArray();
            return VegetableResponse::listVegetableResponse('success', $vegetables);
        } catch (Exception $e) {
            return VegetableResponse::listVegetableResponse('error', null, $e->getMessage());
        }
    }
}
