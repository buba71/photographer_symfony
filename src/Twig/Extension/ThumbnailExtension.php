<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
Use Intervention\Image\ImageManager;


class ThumbnailExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('thumb', array($this, 'thumbnailFilter')),
        );
    }

    public function thumbnailFilter($image)
    {
        // Retrieve the original image path
        $imagePath = '../public'.$image;

        // Define image source path
        $thumbPath = '/uploads/images/thumbs//'.pathinfo($imagePath,PATHINFO_FILENAME) .'.jpg';

        // If no exist, create thumbnails Directory storage
        $thumbDir = '../public/uploads/images/thumbs';
        if(!file_exists($thumbDir)) {
            mkdir($thumbDir);
        }

        // Intervention Image Process image
        $manager = new ImageManager();

        $thumbImage = $manager
            ->make($imagePath)
            ->fit(200, 200)
            ->save('../public'.$thumbPath, 100)
        ;

        return $thumbPath;

    }
}