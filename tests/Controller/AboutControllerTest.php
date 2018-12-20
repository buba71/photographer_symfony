<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AboutControllerTest extends WebTestCase
{
    public function testIndex():void
    {
        $client = static::createClient();

        $client->request('GET', '/about');

        static::assertEquals(200, $client->getResponse()->getStatusCode());
    }
}