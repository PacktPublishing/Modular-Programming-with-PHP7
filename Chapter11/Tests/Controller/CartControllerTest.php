<?php

namespace Foggyline\SalesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CartControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testAddToCartAndAccessCheckout()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/');
        $crawler = $this->client->click($crawler->selectLink('Add to Cart')->link());
        $crawler = $this->client->followRedirect();

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("added to cart")')->count());

        $crawler = $this->client->request('GET', '/sales/cart/');
        $crawler = $this->client->click($crawler->selectLink('Go to Checkout')->link());


        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Checkout")')->count());
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
}
