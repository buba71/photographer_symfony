<?php

namespace tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $response = $client->getResponse()->getContent();

        var_dump($response);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}