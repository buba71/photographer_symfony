<?php

namespace tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * @ In this test, user have not  some images.
     * @ Get the userAccount Controller response
     * @ return void
     */
    public function testIndex():void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Connexion')->form();

        $form['_username'] = 'john';
        $form['_password'] = 'john';
        $crawler = $client->submit($form);

        $client->followRedirect();

        $crawler = $client->request('GET', '/account');


        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}