<?php

namespace AppBundle\Service\Menu;

class Category
{
    public function getItems()
    {
        return array(
                array('path' => 'women', 'label' => 'Women'),
                array('path' => 'men', 'label' => 'Men'),
                array('path' => 'sport', 'label' => 'Sport'),
        );
    }
}
