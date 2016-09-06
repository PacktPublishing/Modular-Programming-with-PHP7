<?php

namespace Foggyline\ShipmentBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FlatRateShipmentTest extends KernelTestCase
{
    private $container;
    private $router;

    private $street = 'Masonic Hill Road';
    private $city = 'Little Rock';
    private $country = 'US';
    private $postcode = 'AR 72201';
    private $amount = 199.99;
    private $qty = 7;

    public function setUp()
    {
        static::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->router = $this->container->get('router');
    }

    public function testGetInfoViaService()
    {
        $shipment = $this->container->get('foggyline_shipment.flat_rate');

        $info = $shipment->getInfo(
            $this->street, $this->city, $this->country, $this->postcode, $this->amount, $this->qty
        );

        $this->validateGetInfoResponse($info);
    }

    public function testGetInfoViaClass()
    {
        $shipment = new \Foggyline\ShipmentBundle\Service\FlatRateShipment($this->router);

        $info = $shipment->getInfo(
            $this->street, $this->city, $this->country, $this->postcode, $this->amount, $this->qty
        );

        $this->validateGetInfoResponse($info);
    }

    public function validateGetInfoResponse($info)
    {
        $this->assertNotEmpty($info);
        $this->assertNotEmpty($info['shipment']['title']);
        $this->assertNotEmpty($info['shipment']['code']);
        $this->assertNotEmpty($info['shipment']['delivery_options']);
        $this->assertNotEmpty($info['shipment']['url_process']);
    }
}
