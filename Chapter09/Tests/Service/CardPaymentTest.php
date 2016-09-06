<?php

namespace Foggyline\PaymentBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CardPaymentTest extends KernelTestCase
{
    private $container;
    private $formFactory;
    private $router;

    public function setUp()
    {
        static::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->formFactory = $this->container->get('form.factory');
        $this->router = $this->container->get('router');
    }

    public function testGetInfoViaService()
    {
        $payment = $this->container->get('foggyline_payment.card_payment');
        $info = $payment->getInfo();
        $this->assertNotEmpty($info);
        $this->assertNotEmpty($info['payment']['form']);
    }

    public function testGetInfoViaClass()
    {
        $payment = new \Foggyline\PaymentBundle\Service\CardPayment(
            $this->formFactory,
            $this->router
        );

        $info = $payment->getInfo();
        $this->assertNotEmpty($info);
        $this->assertNotEmpty($info['payment']['form']);
    }
}
