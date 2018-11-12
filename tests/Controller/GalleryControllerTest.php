<?php

namespace tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GalleryControllerTest extends WebTestCase
{
    private $client=null;

    public function setUp():void
    {
        $this->client = static::createClient();

    }

    /**
     * $ Get the galleryController index response
     * @ return void
     */
    public function testIndex():void
    {
        $this->client->request('GET', '/gallery');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }



}
