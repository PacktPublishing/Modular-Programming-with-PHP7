<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:default:index.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('AppBundle:default:about.html.twig');
    }

    /**
     * @Route("/customer-service", name="customer_service")
     */
    public function customerServiceAction()
    {
        return $this->render('AppBundle:default:customer-service.html.twig');
    }

    /**
     * @Route("/orders-and-returns", name="orders_returns")
     */
    public function ordersAndReturnsAction()
    {
        return $this->render('AppBundle:default:orders-returns.html.twig');
    }

    /**
     * @Route("/privacy-and-cookie-policy", name="privacy_cookie")
     */
    public function privacyAndCookiePolicyAction()
    {
        return $this->render('AppBundle:default:privacy-cookie.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {

        // Build a form, with validation rules in place
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array(
                'constraints' => new NotBlank()
            ))
            ->add('email', EmailType::class, array(
                'constraints' => new Email()
            ))
            ->add('message', TextareaType::class, array(
                'constraints' => new Length(array('min' => 3))
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Reach Out!',
                'attr' => array('class' => 'button'),
            ))
            ->getForm();

        // Check if this is a POST type request and if so, handle form
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash(
                    'success',
                    'Your form has been submitted. Thank you.'
                );

                // todo: Send an email out to website admin or something...

                return $this->redirect($this->generateUrl('contact'));
            }
        }

        // Render "contact us" page
        return $this->render('AppBundle:default:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/new-category", name="category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $category = new \Foggyline\CatalogBundle\Entity\Category();
        $form = $this->createForm('Foggyline\CatalogBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $image \Symfony\Component\HttpFoundation\File\UploadedFile */
            if ($image = $category->getImage()) {
                $name = $this->get('foggyline_catalog.image_uploader')->upload($image);
                $category->setImage($name);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_show', array('id' => $category->getId()));
        }

        return $this->render('FoggylineCatalogBundle:default:category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }
}
