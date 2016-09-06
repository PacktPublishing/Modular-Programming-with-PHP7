<?php

namespace Foggyline\SalesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CartController extends Controller
{
    public function indexAction()
    {
        if ($customer = $this->getUser()) {
            $em = $this->getDoctrine()->getManager();


            $cart = $em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(array('customer' => $customer));
            $items = $cart->getItems();
            $total = null;

            foreach ($items as $item) {
                $total += floatval($item->getQty() * $item->getUnitPrice());
            }

            return $this->render('FoggylineSalesBundle:default:cart/index.html.twig', array(
                'customer' => $customer,
                'items' => $items,
                'total' => $total,
            ));
        } else {
            $this->addFlash('warning', 'Only logged in customers can access cart page.');
            return $this->redirectToRoute('foggyline_customer_login');
        }
    }

    public function updateAction(Request $request)
    {
        $items = $request->get('item');

        $em = $this->getDoctrine()->getManager();

        foreach ($items as $_id => $_qty) {
            $cartItem = $em->getRepository('FoggylineSalesBundle:CartItem')->find($_id);
            if (intval($_qty) > 0) {
                $cartItem->setQty($_qty);
                $em->persist($cartItem);
            } else {
                $em->remove($cartItem);
            }
        }
        // Persist to database
        $em->flush();

        $this->addFlash('success', 'Cart updated.');

        return $this->redirectToRoute('foggyline_sales_cart');
    }

    public function addAction($id)
    {
        if ($customer = $this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $now = new \DateTime();

            $product = $em->getRepository('FoggylineCatalogBundle:Product')->find($id);

            // Grab the cart for current user
            $cart = $em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(array('customer' => $customer));

            // If there is no cart, create one
            if (!$cart) {
                $cart = new \Foggyline\SalesBundle\Entity\Cart();
                $cart->setCustomer($customer);
                $cart->setCreatedAt($now);
                $cart->setModifiedAt($now);
            } else {
                $cart->setModifiedAt($now);
            }

            $em->persist($cart);
            $em->flush();

            // Grab the possibly existing cart item
            // But, lets find it directly
            $cartItem = $em->getRepository('FoggylineSalesBundle:CartItem')->findOneBy(array('cart' => $cart, 'product' => $product));

            if ($cartItem) {
                // Cart item exists, update it
                $cartItem->setQty($cartItem->getQty() + 1);
                $cartItem->setModifiedAt($now);
            } else {
                // Cart item does not exist, add new one
                $cartItem = new \Foggyline\SalesBundle\Entity\CartItem();
                $cartItem->setCart($cart);
                $cartItem->setProduct($product);
                $cartItem->setQty(1);
                $cartItem->setUnitPrice($product->getPrice());
                $cartItem->setCreatedAt($now);
                $cartItem->setModifiedAt($now);
            }

            $em->persist($cartItem);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully added to cart', $product->getTitle()));

            return $this->redirectToRoute('foggyline_sales_cart');
        } else {
            $this->addFlash('warning', 'Only logged in users can add to cart.');
            return $this->redirect('/');
        }
    }


}
