<?php

namespace Foggyline\SalesBundle\Service;

class Payment
{
    private $container;
    private $methods;

    public function __construct($container, $methods)
    {
        $this->container = $container;
        $this->methods = $methods;
    }

    public function getAvailableMethods()
    {
        $methods = array();

        foreach ($this->methods as $_method) {
            $methods[] = $this->container->get($_method);
        }

        return $methods;
    }
}