<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
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
        $this->client->submit($form, ['_username' => 'Admin', '_password' => '1234']);
    }

    public function testListActionForAnonymous()
    {
        $crawler = $this->client->request('GET', '/tasks');

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
    }

    public function testListAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        // Check if the title is correct
        $this->assertSame(1, $crawler->filter('html:contains("Tâches à faire")')->count());

        // Check if the title page tag is correct
        $this->assertSame(1, $crawler->filter('h1')->count());
    }

    public function testListFinishedAction()
    {
        $this->loginUser();

        $this->client->request('GET', '/finished-tasks');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'titre de test création';
        $form['task[content]'] = 'contenu de test création';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testEditAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/6/edit');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'titre de test édition';
        $form['task[content]'] = 'contenu de test édition';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testToggleTaskAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/6/toggle');

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testDeleteTaskAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/6/delete');

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}