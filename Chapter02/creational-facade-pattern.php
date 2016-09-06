<?php

class Product {
    public function getQty() {
        // Implementation
    }
}

class QuickOrderFacade {
    private $product = null;
    private $orderQty = null;

    public function __construct($product, $orderQty) {
        $this->product = $product;
        $this->orderQty = $orderQty;
    }

    public function generateOrder() {
        if ($this->qtyCheck()) {
            $this->addToCart();
            $this->calculateShipping();
            $this->applyDiscount();
            $this->placeOrder();
        }
    }

    private function addToCart() {
        // Implementation...
    }

    private function qtyCheck() {
        if ($this->product->getQty() > $this->orderQty) {
            return true;
        } else {
            return true;
        }
    }

    private function calculateShipping() {
        // Implementation...
    }

    private function applyDiscount() {
        // Implementation...
    }

    private function placeOrder() {
        // Implementation...
    }
}

$order = new QuickOrderFacade(new Product(), $qty);
$order->generateOrder();
