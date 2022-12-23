<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

function imgSmall($fileName, $object, $subobject = null)
{
    $path = (is_null($subobject)) ? $object : $object . '/' . $subobject;

    return imgResize($path, $fileName, 'small');
}
function imgMedium($fileName, $object, $subobject = null)
{
    $path = (is_null($subobject)) ? $object : $object . '/' . $subobject;

    return imgResize($path, $fileName, 'medium');
}
function imgLarge($fileName, $object, $subobject = null)
{
    $path = (is_null($subobject)) ? $object : $object . '/' . $subobject;

    return imgResize($path, $fileName, 'large');
}

function imgResize($path, $fileName, $size)
{
    if(is_null($fileName)) {
        return '';
    }
    if (!file_exists(Storage::path($path . '/' . $fileName))) {
        return '';
    }

    switch ($size) {
        case 'small':
            $width = 60;
            $height = 60;
            break;
        case 'medium':
            $width = 250;
            $height = 250;
            break;
        case 'large':
            $width = 450;
            $height = 450;
            break;
    }

    $imageURL = asset('storage/' . $path. '/' . $size . '/'. $fileName);
    $fileNameNew = Storage::path($path . '/' . $size . '/' . $fileName);

    if (file_exists($fileNameNew)) {
        return $imageURL;
    }
    if (!is_dir(Storage::path($path . '/' . $size))) {
        Storage::makeDirectory($path . '/' . $size);
    }
    $thumbnail = Image::make(Storage::path($path. '/' . $fileName));
    $thumbnail->resize(null, $height, function ($constraint) {
        $constraint->aspectRatio();
    });
    if ($thumbnail->width() > $width) {
        $thumbnail->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
    }
    $thumbnail->save($fileNameNew);

    return $imageURL;
}
