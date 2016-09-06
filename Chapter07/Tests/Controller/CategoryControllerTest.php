<?php

namespace Foggyline\CatalogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient(
            array(), array(
                'PHP_AUTH_USER' => 'john',
                'PHP_AUTH_PW' => '1L6lllW9zXg0',
            )
        );

        // Create a new entry in the database
        $crawler = $client->request('GET', '/category/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /product/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'category[title]' => 'Test',
            'category[urlKey]' => 'Test urlKey',
            'category[description]' => 'Test description',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('h1:contains("Test")')->count(), 'Missing element h1:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'category[title]' => 'Foo',
            'category[urlKey]' => 'Foo urlKey',
            'category[description]' => 'Foo description',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo title/', $client->getResponse()->getContent());
    }


}
