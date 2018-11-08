<?php

namespace tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testSendMail():void
    {
        $client = static :: createClient();

        $crawler = $client->request('GET', '/contact');

        $form = $crawler->selectButton('Envoyer')->form();

        $form['contact[name]'] = 'De Lima';
        $form['contact[firstName]'] = 'David';
        $form['contact[email]'] = 'jhon.doe@gmail.com';
        $form['contact[message]'] = 'Message from Jhon Doe.';

        $crawler = $client->submit($form);

        $crawler = $client->followRedirect();

        static ::assertEquals(200, $client->getResponse()->getStatusCode());

    }
}