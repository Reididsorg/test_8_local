<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
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

    public function testLogin()
    {
        $this->loginUser();

        $this->client->request('GET', '/login');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLogout()
    {
        $this->loginUser();

        $this->client->request('GET', '/logout');

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }
}