<?php

namespace tests\Twig\Extension;

use App\Entity\Image;
use App\Services\interventionImageProcess;
use App\Twig\Extension\ThumbnailExtension;
use PHPUnit\Framework\TestCase;

class ThumbnailExtensionTest extends TestCase
{
    private $manager;

    public function setUp():void
    {
        $this->manager = static::createMock(interventionImageProcess::class);

    }

    /**
     * @ Test thumb path filter
     * @ return void
     */
    public function testThumbnailFilter():void
    {
        $image = new Image();
        $image->setImage('1234.jpg');

        $filter = new ThumbnailExtension($this->manager);

        $thumbPath = $filter->thumbnailFilter($image);

        static::assertEquals('/uploads/images/thumbs//public1234.jpg', $thumbPath);

    }
}