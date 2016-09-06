<?php

namespace Foggyline\SalesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class CheckoutController extends Controller
{
    public function indexAction()
    {
        // Fetch current logged in customer
        if ($customer = $this->getUser()) {

            $form = $this->getAddressForm();

            $em = $this->getDoctrine()->getManager();
            $cart = $em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(array('customer' => $customer));
            $items = $cart->getItems();
            $total = null;

            foreach ($items as $item) {
                $total += floatval($item->getQty() * $item->getUnitPrice());
            }

            return $this->render('FoggylineSalesBundle:default:checkout/index.html.twig', array(
                'customer' => $customer,
                'items' => $items,
                'cart_subtotal' => $total,
                'shipping_address_form' => $form->createView(),
                'shipping_methods' => $this->get('foggyline_sales.shipment')->getAvailableMethods()
            ));
        } else {
            $this->addFlash('warning', 'Only logged in customers can access checkout page.');
            return $this->redirectToRoute('foggyline_customer_login');
        }
    }

    private function getAddressForm()
    {
        return $this->createFormBuilder()
            ->add('address_first_name', TextType::class, array('required' => true))
            ->add('address_last_name', TextType::class, array('required' => true))
            ->add('company', TextType::class, array())
            ->add('address_telephone', TextType::class, array('required' => true))
            ->add('address_country', CountryType::class, array('required' => true))
            ->add('address_state', TextType::class, array())
            ->add('address_city', TextType::class, array('required' => true))
            ->add('address_postcode', TextType::class, array('required' => true))
            ->add('address_street', TextType::class, array('required' => true))
            ->getForm();
    }

    public function paymentAction(Request $request)
    {
        $addressForm = $this->getAddressForm();
        $addressForm->handleRequest($request);

        if ($addressForm->isSubmitted() && $addressForm->isValid() && $customer = $this->getUser()) {

            $em = $this->getDoctrine()->getManager();
            $cart = $em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(array('customer' => $customer));
            $items = $cart->getItems();
            $cartSubtotal = null;

            foreach ($items as $item) {
                $cartSubtotal += floatval($item->getQty() * $item->getUnitPrice());
            }

            // Incoming shipment_method is comprised of method code + delivery code + delivery price
            // Note, this is dangerous part, we should not really be passing on shipment price from storefront
            $shipmentMethod = $_POST['shipment_method'];
            $shipmentMethod = explode('____', $shipmentMethod);
            $shipmentMethodCode = $shipmentMethod[0];
            $shipmentMethodDeliveryCode = $shipmentMethod[1];
            $shipmentMethodDeliveryPrice = $shipmentMethod[2];

            // Store relevant info into session
            $checkoutInfo = $addressForm->getData();
            $checkoutInfo['shipment_method'] = $shipmentMethodCode . '____' . $shipmentMethodDeliveryCode;
            $checkoutInfo['shipment_price'] = $shipmentMethodDeliveryPrice;
            $checkoutInfo['items_price'] = $cartSubtotal;
            $checkoutInfo['total_price'] = $cartSubtotal + $shipmentMethodDeliveryPrice;
            $this->get('session')->set('checkoutInfo', $checkoutInfo);

            return $this->render('FoggylineSalesBundle:default:checkout/payment.html.twig', array(
                'customer' => $customer,
                'items' => $items,
                'cart_subtotal' => $cartSubtotal,
                'delivery_subtotal' => $shipmentMethodDeliveryPrice,
                'delivery_label' => 'Delivery Label Here',
                'order_total' => $cartSubtotal + $shipmentMethodDeliveryPrice,
                'payment_methods' => $this->get('foggyline_sales.payment')->getAvailableMethods()
            ));
        } else {
            $this->addFlash('warning', 'Only logged in customers can access checkout page.');
            return $this->redirectToRoute('foggyline_customer_login');
        }
    }

    public function processAction()
    {
        if ($customer = $this->getUser()) {

            $em = $this->getDoctrine()->getManager();
            // Merge all the checkout info, for SalesOrder
            $checkoutInfo = $this->get('session')->get('checkoutInfo');
            $now = new \DateTime();

            // Create Sales Order
            $salesOrder = new \Foggyline\SalesBundle\Entity\SalesOrder();
            $salesOrder->setCustomer($customer);
            $salesOrder->setItemsPrice($checkoutInfo['items_price']);
            $salesOrder->setShipmentPrice($checkoutInfo['shipment_price']);
            $salesOrder->setTotalPrice($checkoutInfo['total_price']);
            $salesOrder->setPaymentMethod($_POST['payment_method']);
            $salesOrder->setShipmentMethod($checkoutInfo['shipment_method']);
            $salesOrder->setCreatedAt($now);
            $salesOrder->setModifiedAt($now);
            $salesOrder->setCustomerEmail($customer->getEmail());
            $salesOrder->setCustomerFirstName($customer->getFirstName());
            $salesOrder->setCustomerLastName($customer->getLastName());
            $salesOrder->setAddressFirstName($checkoutInfo['address_first_name']);
            $salesOrder->setAddressLastName($checkoutInfo['address_last_name']);
            $salesOrder->setAddressCountry($checkoutInfo['address_country']);
            $salesOrder->setAddressState($checkoutInfo['address_state']);
            $salesOrder->setAddressCity($checkoutInfo['address_city']);
            $salesOrder->setAddressPostcode($checkoutInfo['address_postcode']);
            $salesOrder->setAddressStreet($checkoutInfo['address_street']);
            $salesOrder->setAddressTelephone($checkoutInfo['address_telephone']);
            $salesOrder->setStatus(\Foggyline\SalesBundle\Entity\SalesOrder::STATUS_PROCESSING);

            $em->persist($salesOrder);
            $em->flush();

            // Foreach cart item, create order item, and delete cart item
            $cart = $em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(array('customer' => $customer));
            $items = $cart->getItems();

            foreach ($items as $item) {
                $orderItem = new \Foggyline\SalesBundle\Entity\SalesOrderItem();

                $orderItem->setSalesOrder($salesOrder);
                $orderItem->setTitle($item->getProduct()->getTitle());
                $orderItem->setQty($item->getQty());
                $orderItem->setUnitPrice($item->getUnitPrice());
                $orderItem->setTotalPrice($item->getQty() * $item->getUnitPrice());
                $orderItem->setModifiedAt($now);
                $orderItem->setCreatedAt($now);
                $orderItem->setProduct($item->getProduct());

                $em->persist($orderItem);
                $em->remove($item);
            }

            $em->remove($cart);
            $em->flush();

            $this->get('session')->set('last_order', $salesOrder->getId());
            return $this->redirectToRoute('foggyline_sales_checkout_success');
        } else {
            $this->addFlash('warning', 'Only logged in customers can access checkout page.');
            return $this->redirectToRoute('foggyline_customer_login');
        }
    }

    public function successAction()
    {

        return $this->render('FoggylineSalesBundle:default:checkout/success.html.twig', array(
            'last_order' => $this->get('session')->get('last_order')
        ));
    }
}
