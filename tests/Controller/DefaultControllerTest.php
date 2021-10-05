<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['_username' => 'User', '_password' => '1234']);
    }

    public function testIndexAction()
    {
        $this->client->request('GET', '/');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
}