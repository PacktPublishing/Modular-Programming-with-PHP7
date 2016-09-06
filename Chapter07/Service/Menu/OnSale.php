<?php

namespace Foggyline\CatalogBundle\Service\Menu;

class OnSale
{
    private $em;
    private $router;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager, $router)
    {
        $this->em = $entityManager;
        $this->router = $router;
    }

    public function getItems()
    {
        $products = array();
        $_products = $this->em->getRepository('FoggylineCatalogBundle:Product')->findBy(
            array('onsale' => true),
            null,
            5
        );

        foreach ($_products as $_product) {
            /* @var $_product \Foggyline\CatalogBundle\Entity\Product */
            $products[] = array(
                'path' => $this->router->generate('product_show', array('id' => $_product->getId())),
                'name' => $_product->getTitle(),
                'image' => $_product->getImage(),
                'price' => $_product->getPrice(),
                'id' => $_product->getId(),
            );
        }

        return $products;
    }
}
