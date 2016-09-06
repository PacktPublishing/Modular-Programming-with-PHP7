<?php

class Address
{
    private $customer;
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
}

$customer = new stdClass();

try {
    $address = new Address($customer);
} catch (\Exception $e) {
    echo 'handling';
} finally {
    echo 'cleanup';
}
