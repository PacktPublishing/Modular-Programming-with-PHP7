<?php

interface PaymentStrategy
{
    public function pay($amount);
}

class StripePayment implements PaymentStrategy
{
    public function pay($amount)
    {
        echo 'StripePayment...';
    }

}

class PayPalPayment implements PaymentStrategy
{
    public function pay($amount)
    {
        echo 'PayPalPayment...';
    }
}

class Checkout
{
    private $amount = 0;

    public function __construct($amount = 0)
    {
        $this->amount = $amount;
    }

    public function capturePayment()
    {
        if ($this->amount > 99.99) {
            $payment = new PayPalPayment();
        } else {
            $payment = new StripePayment();
        }

        $payment->pay($this->amount);
    }
}

$checkout = new Checkout(49.99);
$checkout->capturePayment(); // StripePayment...

$checkout = new Checkout(199.99);
$checkout->capturePayment(); // PayPalPayment...
