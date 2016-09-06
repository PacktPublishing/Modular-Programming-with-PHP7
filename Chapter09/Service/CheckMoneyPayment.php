<?php

namespace Foggyline\PaymentBundle\Service;

class CheckMoneyPayment
{
    private $router;

    public function __construct(
        \Symfony\Bundle\FrameworkBundle\Routing\Router $router
    )
    {
        $this->router = $router;
    }

    public function getInfo()
    {
        return array(
            'payment' => array(
                'title' => 'Foggyline Check Money Payment',
                'code' => 'check_money',
                'url_authorize' => $this->router->generate('foggyline_payment_check_money_authorize'),
                'url_capture' => $this->router->generate('foggyline_payment_check_money_capture'),
                'url_cancel' => $this->router->generate('foggyline_payment_check_money_cancel'),
                //'form' => ''
            )
        );
    }
}