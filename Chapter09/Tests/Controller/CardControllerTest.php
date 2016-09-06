<?php

namespace Foggyline\PaymentBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CardControllerTest extends WebTestCase
{
    private $client;
    private $router;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }

    public function testAuthorizeAction()
    {
        $this->client->request('GET', $this->router->generate('foggyline_payment_card_authorize'));
        $this->assertTests();
    }

    public function testCaptureAction()
    {
        $this->client->request('GET', $this->router->generate('foggyline_payment_card_capture'));
        $this->assertTests();
    }

    public function testCancelAction()
    {
        $this->client->request('GET', $this->router->generate('foggyline_payment_card_cancel'));
        $this->assertTests();
    }

    private function assertTests()
    {
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('success', $this->client->getResponse()->getContent());
        $this->assertNotEmpty($this->client->getResponse()->getContent());
    }
}
