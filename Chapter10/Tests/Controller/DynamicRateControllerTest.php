<?php

namespace Foggyline\ShipmentBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DynamicRateControllerTest extends WebTestCase
{
    private $client;
    private $router;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }

    public function testProcessAction()
    {
        $this->client->request('GET', $this->router->generate('foggyline_shipment_dynamic_rate_process'));
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('success', $this->client->getResponse()->getContent());
        $this->assertNotEmpty($this->client->getResponse()->getContent());
    }
}
