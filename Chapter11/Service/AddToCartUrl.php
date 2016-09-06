<?php

namespace Foggyline\SalesBundle\Service;

class AddToCartUrl
{
    private $em;
    private $router;

    public function __construct(
        \Doctrine\ORM\EntityManager $entityManager,
        \Symfony\Bundle\FrameworkBundle\Routing\Router $router
    )
    {
        $this->em = $entityManager;
        $this->router = $router;
    }

    public function getAddToCartUrl($productId)
    {
        return $this->router->generate('foggyline_sales_cart_add', array('id' => $productId));
    }
}
