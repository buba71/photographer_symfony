<?php

namespace tests\Entity;

use App\Entity\Gallery;
use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GalleryTest extends WebTestCase
{
    public function testGallery()
    {
        $image = new Image();
        $image->setImage('1234');

        $gallery = new Gallery();
        $gallery->setName('Architecture');
        $gallery->addImage($image);


        static::assertEquals('Architecture', $gallery->getName());

    }

}