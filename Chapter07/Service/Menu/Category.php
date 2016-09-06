<?php

namespace Foggyline\CatalogBundle\Service\Menu;

class Category
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
        $categories = array();
        $_categories = $this->em->getRepository('FoggylineCatalogBundle:Category')->findAll();

        foreach ($_categories as $_category) {
            /* @var $_category \Foggyline\CatalogBundle\Entity\Category */
            $categories[] = array(
                'path' => $this->router->generate('category_show', array('id' => $_category->getId())),
                'label' => $_category->getTitle(),
            );
        }

        return $categories;
    }
}
