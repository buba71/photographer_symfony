<?php

namespace tests\Entity;

use App\Entity\Gallery;
use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImageTest extends WebTestCase
{
    /**
     * test Image entity setters and getters
     */
    public function testImage()
    {
        $gallery = new Gallery();
        $gallery->setName('any gallery');

        $image = new Image();
        $image->setNumberOfLike(1);
        $image->setImage('1234');
        $image->setPlace('any place');
        $image->setGallery($gallery);

        static :: assertEquals(1, $image->getNumberOfLike());
        static :: assertEquals('1234', $image->getImage());
        static :: assertEquals('any place', $image->getPlace());

    }
}