<?php

namespace App\Core\Uploader;

use File;
use Storage;
use Illuminate\Http\UploadedFile;

abstract class Uploader
{
    protected $file;
    protected $directory;

    /**
     * @param UploadedFile|null
     */
    public function __construct($file = null)
    {
        $this->file = $file;
        $this->directory = $this->getDirectory();
    }

    /**
     * @param UploadedFile
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        return $this->file;
    }

    abstract protected function getDirectory();

    /**
     * @param  UploadedFile|null
     * @return string
     */
    public function make($file = null)
    {
        if ($file instanceof UploadedFile) {
            $this->setFile($file);
        }

        if (!$this->file) {
            return false;
        }

        $fileName = $this->constructFileName();
        $directoryUrl = storage_path('app/'. $this->directory);
        File::exists($directoryUrl) || File::makeDirectory($directoryUrl, 0776, true, true);

        return $this->file->storeAs($this->directory, $fileName);
    }

    /**
     * Generate a unique name which the uploaded file will be saved as.
     *
     * @return string
     */
    protected function constructFileName()
    {
        $name = uniqid();
        $extension = $this->file->getClientOriginalExtension();

        return "{$name}.{$extension}";
    }
}
