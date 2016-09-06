<?php

namespace Foggyline\PaymentBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CheckMoneyPaymentTest extends KernelTestCase
{
    private $container;
    private $router;

    public function setUp()
    {
        static::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->router = $this->container->get('router');
    }

    public function testGetInfoViaService()
    {
        $payment = $this->container->get('foggyline_payment.check_money');
        $info = $payment->getInfo();
        $this->assertNotEmpty($info);
    }

    public function testGetInfoViaClass()
    {
        $payment = new \Foggyline\PaymentBundle\Service\CheckMoneyPayment(
            $this->router
        );

        $info = $payment->getInfo();
        $this->assertNotEmpty($info);
    }
}
