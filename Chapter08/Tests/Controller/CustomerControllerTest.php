<?php

namespace Foggyline\CustomerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class CustomerControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testMyAccountAccess()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/customer/account');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("My Account")')->count());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'foggyline_customer'; // firewall name

        $em = $this->client->getContainer()->get('doctrine')->getManager();
        $user = $em->getRepository('FoggylineCustomerBundle:Customer')->findOneByUsername('ajzele@gmail.com');

        $token = new UsernamePasswordToken($user, null, $firewall, array('ROLE_USER'));
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function testRegisterForm()
    {
        $crawler = $this->client->request('GET', '/customer/register');
        $uniqid = uniqid();
        $form = $crawler->selectButton('Register!')->form(array(
            'customer[email]' => 'john_' . $uniqid . '@test.loc',
            'customer[username]' => 'john_' . $uniqid,
            'customer[plainPassword][first]' => 'pass123',
            'customer[plainPassword][second]' => 'pass123',
            'customer[firstName]' => 'John',
            'customer[lastName]' => 'Doe',
            'customer[company]' => 'Foggyline',
            'customer[phoneNumber]' => '00 385 111 222 333',
            'customer[country]' => 'HR',
            'customer[state]' => 'Osijek',
            'customer[city]' => 'Osijek',
            'customer[postcode]' => '31000',
            'customer[street]' => 'The Yellow Street',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        //var_dump($this->client->getResponse()->getContent());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("customer/login")')->count());
    }

    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/customer/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /customer/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'foggyline_customerbundle_customer[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'foggyline_customerbundle_customer[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    */
}
