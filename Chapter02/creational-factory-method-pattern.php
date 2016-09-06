<?php

interface ProductFactory {
    public function makeProduct();
}

interface Product {
    public function getType();
}

class SimpleProductFactory implements ProductFactory {
    public function makeProduct() {
        return new SimpleProduct();
    }
}

class SimpleProduct implements Product {
    public function getType() {
        return 'SimpleProduct';
    }
}

/* Client */
$factory = new SimpleProductFactory();
$product = $factory->makeProduct();
echo $product->getType();
