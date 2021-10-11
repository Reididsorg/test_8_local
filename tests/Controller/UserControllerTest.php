<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use function Zenstruck\Foundry\factory;

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

        $crawler = $this->client->request('GET', '/users/create');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'zozo';
        $form['user[password][first]'] = '1234';
        $form['user[password][second]'] = '1234';
        $form['user[email]'] = 'zozo@zozo.fr';
        $form['user[roles][0]'] = 'ROLE_ADMIN';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testEditAction()
    {
        $this->loginAdminUser();

        $crawler = $this->client->request('GET', '/users/2/edit');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'User';
        $form['user[password][first]'] = '1234';
        $form['user[password][second]'] = '1234';
        $form['user[email]'] = 'user@usermodifie.fr';
        //$form['user[roles][0]'] = '';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}