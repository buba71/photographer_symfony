<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{

    public function testBlogIndex():void
    {
        $client = static::createClient();

        $client->request('GET', '/blog');

        static::assertEquals(200, $client->getResponse()->getStatusCode());

    }


}