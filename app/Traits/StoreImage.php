<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

trait StoreImage {

/**
     * Store uploaded Testimonial image
     *
     * @param $Testimonial
     * @param $request
     * @return bool
     */
    public function storeImage($image, $thumbnailSize = null)
    {

        info('File Param ' . $this->fileParamName);

        if ($image) {

            $name = null;

            if($image){
                $name = time(). "_" . $image->getClientOriginalName();

                $storagePath = public_path('web/images/' . $this->storagePath);

                $this->makeFolder($storagePath);

                if(!empty($thumbnailSize)) {
                    $this->saveThumbnails($image, $thumbnailSize, $name);
                }
                $image->move($storagePath, $name);
            }

            $this->unlinkImage($this->getOriginal($this->fileParamName));

            $this->{$this->imageFieldName} = $name;

            return true;
        } elseif (request()->input('remove_image')) {

            $this->unlinkImage($this->getOriginal($this->fileParamName));

            return true;
        }

        return false;
    }

    public function unlinkImage($image)
    {
        $existing_file = public_path('web/images/' . $this->storagePath . "/") . $image;

        $existing_fileThumbnail = public_path('web/images/' . $this->storagePath . '/thumbnails/' ) . $image;


        info("Thumbnails : " . $existing_fileThumbnail);

        if (file_exists($existing_file)) {
            @unlink($existing_file);
        } else {
            info(" File is not Exists " . $existing_file);
        }

        if (file_exists($existing_fileThumbnail)) {
            @unlink($existing_fileThumbnail);
        } else {
            info(" File Thumbnails is not Exists " . $existing_fileThumbnail);
        }


        return true;
    }


    public function saveThumbnails($image, $thumbnailSize, $name)
    {
        //$image = public_path('web/images/' . $this->storagePath . '/') . $name ;

        $thumbnailpath = public_path('web/images/' . $this->storagePath . '/thumbnails') ;

        $this->makeFolder($thumbnailpath);

        $img = Image::make($image->getRealPath())->resize($thumbnailSize['width'], $thumbnailSize['height'], function($constraint) {
            //$constraint->aspectRatio();
        });
        $img->save($thumbnailpath . '/' . $name);
    }

    public function makeFolder($filePath)
    {
        if(!File::exists($filePath)) {
            File::makeDirectory($filePath);
        }
    }
}
