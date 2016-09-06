<?php

namespace Foggyline\SalesBundle\Service;

class CustomerOrders
{
    private $em;
    private $token;
    private $router;

    public function __construct(
        \Doctrine\ORM\EntityManager $entityManager,
        $tokenStorage,
        \Symfony\Bundle\FrameworkBundle\Routing\Router $router
    )
    {
        $this->em = $entityManager;
        $this->token = $tokenStorage->getToken();
        $this->router = $router;
    }

    public function getOrders()
    {
        $orders = array();

        if ($this->token
            && $this->token->getUser() instanceof \Foggyline\CustomerBundle\Entity\Customer
        ) {
            $salesOrders = $this->em->getRepository('FoggylineSalesBundle:SalesOrder')
                ->findBy(array('customer' => $this->token->getUser()));

            foreach ($salesOrders as $salesOrder) {
                $orders[] = array(
                    'id' => $salesOrder->getId(),
                    'date' => $salesOrder->getCreatedAt()->format('d/m/Y H:i:s'),
                    'ship_to' => $salesOrder->getAddressFirstName() . ' ' . $salesOrder->getAddressLastName(),
                    'order_total' => $salesOrder->getTotalPrice(),
                    'status' => $salesOrder->getStatus(),
                    'actions' => array(
                        array(
                            'label' => 'Cancel',
                            'path' => $this->router->generate('foggyline_sales_order_cancel', array('id' => $salesOrder->getId()))
                        ),
                        array(
                            'label' => 'Print',
                            'path' => $this->router->generate('foggyline_sales_order_print', array('id' => $salesOrder->getId()))
                        )
                    )
                );
            }
        }

        return $orders;

    }
}