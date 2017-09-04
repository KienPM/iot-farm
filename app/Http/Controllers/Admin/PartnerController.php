<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use App\Core\QueryFilter\PartnerFilter;
use App\Core\Responses\Partner\ManageResponse;
use App\Http\Controllers\Core\Traits\PartnerManageTrait;

class PartnerController extends Controller
{
    use PartnerManageTrait;

    protected $guard = 'admin';
    protected $partnerField = ['name', 'email', 'phone_number', 'is_actived'];

    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    public function index(Request $request, PartnerFilter $query)
    {
        try {
            $itemPerPage = $request->get('items_per_page', Partner::ITEMS_PER_PAGE);
            $partners = Partner::filterBy($query)->with('stores')->paginate($itemPerPage)->toArray();

            return ManageResponse::listPartnerResponse('success', $partners);
        } catch (Exception $e) {
            return ManageResponse::listPartnerResponse('error');
        }
    }

    public function show(Partner $partner)
    {
        try {
            $partner = $partner->load(['stores'])->toArray();

            return ManageResponse::listPartnerResponse('success', $partner);
        } catch (Exception $e) {
            return ManageResponse::showPartnerResponse('error');
        }
    }

    public function create(Request $request)
    {
        $this->validateCreateRequest($request);

        try {
            $partnerData = $request->only($partnerField);
            $partner = $this->updateOrCreate($partnerData);

            return ManageResponse::createPartnerResponse('success', $store);
        } catch (Exception $e) {
            return ManageResponse::createPartnerResponse('error');
        }
    }

    public function update(Partner $partner, Request $request)
    {
        $this->validateUpdateRequest($request);

        try {
            $partnerData = $request->all();
            $partner = $this->updateOrCreate($partnerData, $partner->id);

            return ManageResponse::updatePartnerResponse('success', $partner);
        } catch (Exception $e) {
            return ManageResponse::updatePartnerResponse('error');
        }
    }
}
