<?php

class Customer {
    public function __construct() {
        echo '__construct';
    }

    public function __destruct() {
        echo '__destruct';
    }

    public function __toString() {
        echo '__toString';
        return '__toString';
    }

    public function __call($name, $arguments) {
        echo '__call';
    }
}

$customer = new Customer();

$s = serialize($customer); // triggers: __construct, __destruct

$u = unserialize($s); // triggers: __destruct
echo get_class($u); // Customer

$u = unserialize($s, ['allowed_classes'=>false]); // does not trigger anything
echo get_class($u); // __PHP_Incomplete_Class
