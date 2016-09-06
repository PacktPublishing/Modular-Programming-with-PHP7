<?php

namespace Foggyline\CustomerBundle\Tests\Service\Menu;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomerMenu extends KernelTestCase
{
    private $container;
    private $tokenStorage;
    private $router;

    public function setUp()
    {
        static::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->tokenStorage = $this->container->get('security.token_storage');
        $this->router = $this->container->get('router');
    }

    public function testGetItemsViaService()
    {
        $menu = $this->container->get('foggyline_customer.customer_menu');
        $this->assertNotEmpty($menu->getItems());
    }

    public function testGetItemsViaClass()
    {
        $menu = new \Foggyline\CustomerBundle\Service\Menu\CustomerMenu(
            $this->tokenStorage,
            $this->router
        );

        $this->assertNotEmpty($menu->getItems());
    }
}
