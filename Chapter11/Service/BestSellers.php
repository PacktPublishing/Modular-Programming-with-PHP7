<?php

namespace Foggyline\SalesBundle\Service;

class BestSellers
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

    public function getItems()
    {
        $products = array();
        $salesOrderItem = $this->em->getRepository('FoggylineSalesBundle:SalesOrderItem');
        $_products = $salesOrderItem->getBestsellers();

        foreach ($_products as $_product) {
            $products[] = array(
                'path' => $this->router->generate('product_show', array('id' => $_product->getId())),
                'name' => $_product->getTitle(),
                'img' => $_product->getImage(),
                'price' => $_product->getPrice(),
                'id' => $_product->getId(),
            );
        }

        return $products;
    }
}
