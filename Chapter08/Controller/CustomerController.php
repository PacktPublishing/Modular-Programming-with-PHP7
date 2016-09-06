<?php

namespace Foggyline\CustomerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Foggyline\CustomerBundle\Entity\Customer;
use Foggyline\CustomerBundle\Form\CustomerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Customer controller.
 *
 * @Route("/customer")
 */
class CustomerController extends Controller
{
    /**
     * Creates a new Customer entity.
     *
     * @Route("/login", name="foggyline_customer_login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'FoggylineCustomerBundle:default:customer/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route("/register", name="foggyline_customer_register")
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new Customer();
        $form = $this->createForm(CustomerType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('customer_account');
        }

        return $this->render(
            'FoggylineCustomerBundle:default:customer/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Finds and displays a Customer entity.
     *
     * @Route("/account", name="customer_account")
     * @Method({"GET", "POST"})
     */
    public function accountAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }

        if ($customer = $this->getUser()) {

            $editForm = $this->createForm('Foggyline\CustomerBundle\Form\CustomerType', $customer, array( 'action' => $this->generateUrl('customer_account')));
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($customer);
                $em->flush();

                $this->addFlash('success', 'Account updated.');
                return $this->redirectToRoute('customer_account');
            }

            return $this->render('FoggylineCustomerBundle:default:customer/account.html.twig', array(
                'customer' => $customer,
                'form' => $editForm->createView(),
                'customer_orders' => $this->get('foggyline_customer.customer_orders')->getOrders()
            ));
        } else {
            $this->addFlash('notice', 'Only logged in customers can access account page.');
            return $this->redirectToRoute('foggyline_customer_login');
        }
    }

    /**
     * @Route("/forgotten_password", name="customer_forgotten_password")
     * @Method({"GET", "POST"})
     */
    public function forgottenPasswordAction(Request $request)
    {

        // Build a form, with validation rules in place
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, array(
                'constraints' => new Email()
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Reset!',
                'attr' => array('class' => 'button'),
            ))
            ->getForm();

        // Check if this is a POST type request and if so, handle form
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash('success', 'Please check your email for reset password.');

                // todo: Send an email out to website admin or something...

                return $this->redirect($this->generateUrl('foggyline_customer_login'));
            }
        }

        // Render "contact us" page
        return $this->render('FoggylineCustomerBundle:default:customer/forgotten_password.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/logout", name="customer_logout")
     */
    public function logoutAction()
    {
        // The code here won’t actually get hit. Symfony intercepts the request and processes the logout for us.
    }



    /**
     * Lists all Customer entities.
     *
     * @Route("/", name="customer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository('FoggylineCustomerBundle:Customer')->findAll();

        return $this->render('FoggylineCustomerBundle:default:customer/index.html.twig', array(
            'customers' => $customers,
        ));
    }

    /**
     * Creates a new Customer entity.
     *
     * @Route("/new", name="customer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm('Foggyline\CustomerBundle\Form\CustomerType', $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('customer_show', array('id' => $customer->getId()));
        }

        return $this->render('FoggylineCustomerBundle:default:customer/new.html.twig', array(
            'customer' => $customer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Customer entity.
     *
     * @Route("/{id}", name="customer_show")
     * @Method("GET")
     */
    public function showAction(Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);

        return $this->render('FoggylineCustomerBundle:default:customer/show.html.twig', array(
            'customer' => $customer,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Displays a form to edit an existing Customer entity.
     *
     * @Route("/{id}/edit", name="customer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);
        $editForm = $this->createForm('Foggyline\CustomerBundle\Form\CustomerType', $customer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('customer_edit', array('id' => $customer->getId()));
        }

        return $this->render('FoggylineCustomerBundle:default:customer/edit.html.twig', array(
            'customer' => $customer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Customer entity.
     *
     * @Route("/{id}", name="customer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Customer $customer)
    {
        $form = $this->createDeleteForm($customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($customer);
            $em->flush();
        }

        return $this->redirectToRoute('customer_index');
    }

    /**
     * Creates a form to delete a Customer entity.
     *
     * @param Customer $customer The Customer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Customer $customer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customer_delete', array('id' => $customer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



}
