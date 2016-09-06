<?php

namespace Foggyline\CustomerBundle\Service;

class CustomerOrders
{
    public function getOrders()
    {
        return array(
            array(
                'id' => '0000000001',
                'date' => '23/06/2016 18:45',
                'ship_to' => 'John Doe',
                'order_total' => 49.99,
                'status' => 'Processing',
                'actions' => array(
                    array(
                        'label' => 'Cancel',
                        'path' => '#'
                    ),
                    array(
                        'label' => 'Print',
                        'path' => '#'
                    )
                )
            ),
        );
    }
}