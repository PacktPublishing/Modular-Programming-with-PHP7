<?php

namespace AppBundle\Service\Menu;

class Customer
{
    public function getItems()
    {
        // Initial dummy menu
        return array(
            array('path' => 'account', 'label' => 'John Doe'),
            array('path' => 'logout', 'label' => 'Logout'),
        );
    }
}
