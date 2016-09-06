<?php

class Stripe {
    public function capturePayment($amount) {
        /* Implementation... */
    }

    public function authorizeOnlyPayment($amount) {
        /* Implementation... */
    }

    public function cancelAmount($amount) {
        /* Implementation... */
    }
}

interface PaymentService {
    public function capture($amount);
    public function authorize($amount);
    public function cancel($amount);
}

class StripePaymentServiceAdapter implements PaymentService {
    private $stripe;

    public function __construct(Stripe $stripe) {
        $this->stripe = $stripe;
    }

    public function capture($amount) {
        $this->stripe->capturePayment($amount);
    }

    public function authorize($amount) {
        $this->stripe->authorizeOnlyPayment($amount);
    }

    public function cancel($amount) {
        $this->stripe->cancelAmount($amount);
    }
}

// Client
$stripe = new StripePaymentServiceAdapter(new Stripe());
$stripe->authorize(49.99);
$stripe->capture(19.99);
$stripe->cancel(9.99);
