<?php

namespace App\Twig\Extension;

use App\Services\interventionImageProcess;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
Use Intervention\Image\ImageManager;


class ThumbnailExtension extends AbstractExtension
{
    private $interventionImage;

    public function __construct(interventionImageProcess $interventionImage)
    {
        $this->interventionImage = $interventionImage;
    }

    public function getFilters()
    {
        return array(
            new TwigFilter('thumb', array($this, 'thumbnailFilter')),
        );
    }

    /**
     * @ create thumbNail Image and return thumbNail path
     * @param $image
     * @return string
     */
    public function thumbnailFilter($image)
    {
        // Retrieve the original image path
        $imagePath = '../public'.$image;

        // Define image source path
        $thumbPath = '/uploads/images/thumbs//'.pathinfo($imagePath,PATHINFO_FILENAME) .'.jpg';

        $this->interventionImage->processImage($imagePath, $thumbPath);

        return $thumbPath;

    }
}