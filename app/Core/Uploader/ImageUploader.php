<?php

namespace App\Core\Uploader;

use File;
use Storage;
use Illuminate\Http\UploadedFile;
use App\Core\Uploader\Uploader as BaseUploader;
use Image;

class ImageUploader extends BaseUploader
{
    protected $file;

    /**
     * @param  UploadedFile|null
     * @return string
     */
    public function make($file = null)
    {
        $maxSize = config('upload.image_max_size');
        $newImage = parent::make($file);
        if ($newImage && Storage::exists($newImage)) {
            $image = Image::make(storage_path('app/' . $newImage));
            resize_image($image, storage_path('app/' . $this->directory), $maxSize);
        }

        return basename($newImage);
    }

    public function deleteOldFile($oldImage)
    {
        if ($oldImage && Storage::exists($oldImage)) {
            Storage::delete($oldImage);
        }
        $this->deleteOldResizedFile($oldImage);
    }

    protected function getDirectory()
    {
        return 'public/' . config('upload.path.images');
    }

    protected function deleteOldResizedFile($oldImage)
    {
        $oldResized = str_replace_last('.', '.rez.', $oldImage);
        if ($oldResized && Storage::exists($oldResized)) {
            Storage::delete($oldResized);
        }
    }
}
