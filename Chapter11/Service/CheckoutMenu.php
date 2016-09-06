<?php

namespace Foggyline\SalesBundle\Service;

class CheckoutMenu
{
    private $em;
    private $token;
    private $router;

    public function __construct(
        \Doctrine\ORM\EntityManager $entityManager,
        $tokenStorage,
        \Symfony\Bundle\FrameworkBundle\Routing\Router $router
    )
    {
        $this->em = $entityManager;
        $this->token = $tokenStorage->getToken();
        $this->router = $router;
    }

    public function getItems()
    {
        if ($this->token
            && $this->token->getUser() instanceof \Foggyline\CustomerBundle\Entity\Customer
        ) {
            $customer = $this->token->getUser();

            $cart = $this->em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(array('customer' => $customer));

            if ($cart) {
                return array(
                    array('path' => $this->router->generate('foggyline_sales_cart'), 'label' => sprintf('Cart (%s)', count($cart->getItems()))),
                    array('path' => $this->router->generate('foggyline_sales_checkout'), 'label' => 'Checkout'),
                );
            }
        }

        return array();
    }
}
