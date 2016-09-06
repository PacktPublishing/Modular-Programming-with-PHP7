<?php

class ProductIterator implements \Iterator
{
    private $position = 0;
    private $productsCollection;

    public function __construct(ProductCollection $productsCollection)
    {
        $this->productsCollection = $productsCollection;
    }

    public function current()
    {
        return $this->productsCollection->getProduct($this->position);
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return !is_null($this->productsCollection->getProduct($this->position));
    }
}

class ProductCollection implements \IteratorAggregate
{
    private $products = array();

    public function getIterator()
    {
        return new ProductIterator($this);
    }

    public function addProduct($string)
    {
        $this->products[] = $string;
    }

    public function getProduct($key)
    {
        if (isset($this->products[$key])) {
            return $this->products[$key];
        }
        return null;
    }

    public function isEmpty()
    {
        return empty($products);
    }
}

$products = new ProductCollection();
$products->addProduct('T-Shirt Red');
$products->addProduct('T-Shirt Blue');
$products->addProduct('T-Shirt Green');
$products->addProduct('T-Shirt Yellow');

foreach ($products as $product) {
    var_dump($product);
}
