<?php

namespace App\Core\Uploader;

use File;
use Storage;
use Illuminate\Http\UploadedFile;
use App\Core\Uploader\ImageUploader;
use Image;

class VegetableImageUploader extends ImageUploader
{
    protected function getDirectory()
    {
        return 'public/' . config('upload.path.vegetables_image');
    }
}
