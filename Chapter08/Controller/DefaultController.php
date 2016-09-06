<?php

namespace Foggyline\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FoggylineCustomerBundle:Default:index.html.twig');
    }
}
