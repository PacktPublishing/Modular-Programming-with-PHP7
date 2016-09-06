<?php

namespace Foggyline\SalesBundle\Test\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CustomerOrdersTest extends KernelTestCase
{
    private $container;

    public function setUp()
    {
        static::bootKernel();
        $this->container = static::$kernel->getContainer();
    }

    public function testGetOrders()
    {
        $firewall = 'foggyline_customer';

        $em = $this->container->get('doctrine.orm.entity_manager');

        $user = $em->getRepository('FoggylineCustomerBundle:Customer')->findOneByUsername('ajzele@gmail.com');

        $token = new UsernamePasswordToken($user, null, $firewall, array('ROLE_USER'));

        $tokenStorage = $this->container->get('security.token_storage');
        $tokenStorage->setToken($token);

        $orders = new \Foggyline\SalesBundle\Service\CustomerOrders(
            $em,
            $tokenStorage,
            $this->container->get('router')
        );

        $this->assertNotEmpty($orders->getOrders());
    }
}
