<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginAdminUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['_username' => 'Admin', '_password' => '1234']);
    }

    public function loginUserUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['_username' => 'User', '_password' => '1234']);
    }

    public function testListActionForAnonymous()
    {
        $this->client->request('GET', '/users');

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    public function testListActionForUser()
    {
        $this->loginUserUser();

        $this->client->request('GET', '/users');

        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    public function testListActionForAdmin()
    {
        $this->loginAdminUser();

        $this->client->request('GET', '/users');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $this->loginAdminUser();

        $this->client->request('GET', '/users/create');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testEditAction()
    {
        $this->loginAdminUser();

        $this->client->request('GET', '/users/3/edit');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
}