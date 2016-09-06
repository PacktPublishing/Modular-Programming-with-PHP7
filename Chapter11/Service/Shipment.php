<?php

namespace Foggyline\SalesBundle\Service;

class Shipment
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
            $methods[$_method] = $this->container->get($_method);
        }

        return $methods;
    }
//
//    public function getPrice($addressData, $methodCode, $deliveryCode)
//    {
//
//        // Implement a code that once again parses the available shipment methods, and returns final price
//        echo '<pre>'; print_r($this->methods);
//        exit('23');
//    }
}