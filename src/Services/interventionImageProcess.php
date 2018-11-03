<?php

namespace App\Services;

use Intervention\Image\ImageManager;

class interventionImageProcess
{
    public function processImage($imagePath, $thumbPath)
    {
        // Intervention Image Processing image
        $manager = new ImageManager();

        $manager
            ->make($imagePath)
            ->fit(250, 250)
            ->encode('jpg', 100)
            ->save('../public'.$thumbPath, 100)
        ;
    }
}