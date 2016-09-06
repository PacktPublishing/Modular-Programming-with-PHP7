<?php

namespace Foggyline\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FoggylineCatalogBundle:Default:index.html.twig');
    }
}
