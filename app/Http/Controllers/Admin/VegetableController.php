<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Vegetable;
use App\Core\Uploader\VegetableImageUploader;
use App\Core\QueryFilter\VegetableFilter;
use App\Core\Responses\Vegetable\VegetableResponse;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use App\Http\Controllers\Core\VegetableController as BaseController;

class VegetableController extends BaseController
{
    protected $guard = 'admin';

    public function create(Request $request)
    {
        $this->validateCreateRequest($request);
        try {
            DB::beginTransaction();
            $vegetableData = $request->only([
                'category_id',
                'name',
                'description',
                'price',
            ]);
            $vegetable = Vegetable::create($vegetableData);
            $this->addVegetableImages($vegetable, $request);
            DB::commit();

            $vegetable = $this->loadVegetableReletion($vegetable);
            return VegetableResponse::createVegetableResponse('success', $vegetable->toArray());
        } catch (Exception $e) {
            DB::rollBack();
            return VegetableResponse::createVegetableResponse('error', null, $e->getMessage());
        }
    }

    public function update(Vegetable $vegetable, Request $request)
    {
        $this->validateUpdateRequest($request);

        try {
            DB::beginTransaction();
            $vegetableData = $request->only([
                'category_id',
                'name',
                'description',
                'price',
            ]);
            $vegetable = $vegetable->update($vegetableData);
            $this->addVegetableImages($vegetable, $request);
            $this->removeOldVegetableImages($vegetable, $request);
            DB::commit();
            $vegetable = $this->loadVegetableReletion($vegetable);
            return VegetableResponse::updateVegetableResponse('success', $vegetable->toArray());
        } catch (Exception $e) {
            DB::rollBack();
            return VegetableResponse::updateVegetableResponse('error', null, $e->getMessage());
        }
    }

    public function delete(Vegetable $vegetable)
    {
        try {
            $vegetable->images()->delete();
            $vegetable->delete();
            return VegetableResponse::deleteVegetableResponse('success');
        } catch (Exception $e) {
            return VegetableResponse::deleteVegetableResponse('error', null, $e->getMessage());
        }
    }

    public function show(Vegetable $vegetable, Request $request)
    {
        try {
            $itemPerPage = $request->get('items_per_page', Vegetable::ITEMS_PER_PAGE);
            $stores = $vegetable->stores()
                ->paginate($itemPerPage);
            $vegetable = $vegetable->load(['images'])->toArray();
            $vegetable['stores'] = $stores->toArray();

            return VegetableResponse::showVegetableResponse('success', $vegetable);
        } catch (Exception $e) {
            return VegetableResponse::showVegetableResponse('error', null, $e->getMessage());
        }
    }

    protected function validateCreateRequest($request)
    {
        $createRules = [
            'category_id' => 'required:string|exists:vegetable_categories,id',
            'name' => 'required:string',
            'description' => 'max:50000',
            'price' => 'required:interger',
            'images' => 'array',
            'images.*' => 'image|mimes:jpg,jpeg,png'
        ];

        return $this->validate($request, $createRules);
    }

    protected function validateUpdateRequest($request)
    {
        $updateRules = [
            'category_id' => 'required:string|exists:vegetable_categories,id',
            'name' => 'required:string',
            'description' => 'max:50000',
            'price' => 'required:interger',
            'images' => 'array',
            'images_remove' => 'array',
            'images.*' => 'image|mimes:jpg,jpeg,png'
        ];
        return $this->validate($request, $updateRules);
    }

    protected function addVegetableImages(Vegetable $vegetable, Request $request)
    {
        $images = $request->file('images');
        $vegetableImages = [];
        $imageUploader = new VegetableImageUploader();
        foreach ($images as $image) {
            $vegetableImages[] = [
                'src' => $imageUploader->make($image),
                'title' => $vegetable->name,
            ];
        }
        return $vegetable->images()->createMany($vegetableImages);
    }

    /**
     * @param  Vegetable $vegetable
     * @param  Request|array $oldImages
     */
    protected function removeOldVegetableImages(Vegetable $vegetable, $oldImages)
    {
        if ($oldImages instanceof Request) {
            $oldImages = $oldImages->get('images_remove', []);
        }

        $vegetable->images()->whereIn('id', $oldImages)->delete();
    }

    protected function loadVegetableReletion(Vegetable $vegetable)
    {
        return $vegetable->load('images');
    }
}
