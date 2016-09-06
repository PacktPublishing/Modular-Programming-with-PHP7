<?php

namespace AppBundle\Service\Menu;

class OnSale
{
    public function getItems()
    {
        // Note, this can be arranged as per some "Product" interface, so to know what dummy data to return
        return array(
            array('path' => '#', 'name' => 'iPhone', 'image' => '/img/missing-image.png', 'price' => 19.99, 'id' => '#'),
            array('path' => '#', 'name' => 'LG', 'img' => '/img/missing-image.png', 'price' => 29.99, 'id' => '#'),
            array('path' => '#', 'name' => 'Samsung', 'image' => '/img/missing-image.png', 'price' => 39.99, 'id' => '#'),
            array('path' => '#', 'name' => 'Lumia', 'image' => '/img/missing-image.png', 'price' => 49.99, 'id' => '#'),
            array('path' => '#', 'name' => 'Edge', 'image' => '/img/missing-image.png', 'price' => 69.99, 'id' => '#'),
        );
    }
}
