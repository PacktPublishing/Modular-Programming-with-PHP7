<?php

namespace Foggyline\SalesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Foggyline\SalesBundle\Entity\SalesOrder;
use Foggyline\SalesBundle\Form\SalesOrderType;

/**
 * SalesOrder controller.
 *
 * @Route("/salesorder")
 */
class SalesOrderController extends Controller
{
    /**
     * Lists all SalesOrder entities.
     *
     * @Route("/", name="salesorder_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $salesOrders = $em->getRepository('FoggylineSalesBundle:SalesOrder')->findAll();

        return $this->render('FoggylineSalesBundle:default:salesorder/index.html.twig', array(
            'salesOrders' => $salesOrders,
        ));
    }

    /**
     * Creates a new SalesOrder entity.
     *
     * @Route("/new", name="salesorder_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $salesOrder = new SalesOrder();
        $form = $this->createForm('Foggyline\SalesBundle\Form\SalesOrderType', $salesOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($salesOrder);
            $em->flush();

            return $this->redirectToRoute('salesorder_show', array('id' => $salesOrder->getId()));
        }

        return $this->render('FoggylineSalesBundle:default:salesorder/new.html.twig', array(
            'salesOrder' => $salesOrder,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SalesOrder entity.
     *
     * @Route("/{id}", name="salesorder_show")
     * @Method("GET")
     */
    public function showAction(SalesOrder $salesOrder)
    {
        $deleteForm = $this->createDeleteForm($salesOrder);

        return $this->render('FoggylineSalesBundle:default:salesorder/show.html.twig', array(
            'salesOrder' => $salesOrder,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SalesOrder entity.
     *
     * @Route("/{id}/edit", name="salesorder_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SalesOrder $salesOrder)
    {
        $deleteForm = $this->createDeleteForm($salesOrder);
        $editForm = $this->createForm('Foggyline\SalesBundle\Form\SalesOrderType', $salesOrder);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($salesOrder);
            $em->flush();

            return $this->redirectToRoute('salesorder_edit', array('id' => $salesOrder->getId()));
        }

        return $this->render('FoggylineSalesBundle:default:salesorder/edit.html.twig', array(
            'salesOrder' => $salesOrder,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SalesOrder entity.
     *
     * @Route("/{id}", name="salesorder_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SalesOrder $salesOrder)
    {
        $form = $this->createDeleteForm($salesOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($salesOrder);
            $em->flush();
        }

        return $this->redirectToRoute('salesorder_index');
    }

    /**
     * Creates a form to delete a SalesOrder entity.
     *
     * @param SalesOrder $salesOrder The SalesOrder entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SalesOrder $salesOrder)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('salesorder_delete', array('id' => $salesOrder->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function printAction($id)
    {
        if ($customer = $this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $salesOrder = $em->getRepository('FoggylineSalesBundle:SalesOrder')
                ->findOneBy(array('customer' => $customer, 'id' => $id));

            return $this->render('FoggylineSalesBundle:default:salesorder/print.html.twig', array(
                'salesOrder' => $salesOrder,
                'customer' => $customer
            ));
        }

        return $this->redirectToRoute('customer_account');
    }

    public function cancelAction($id)
    {
        if ($customer = $this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $salesOrder = $em->getRepository('FoggylineSalesBundle:SalesOrder')
                ->findOneBy(array('customer' => $customer, 'id' => $id));

            if ($salesOrder->getStatus() != \Foggyline\SalesBundle\Entity\SalesOrder::STATUS_COMPLETE) {
                $salesOrder->setStatus(\Foggyline\SalesBundle\Entity\SalesOrder::STATUS_CANCELED);
                $em->persist($salesOrder);
                $em->flush();
            }
        }

        return $this->redirectToRoute('customer_account');
    }
}
