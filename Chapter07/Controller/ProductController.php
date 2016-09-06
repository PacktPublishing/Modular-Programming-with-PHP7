<?php

namespace Foggyline\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Foggyline\CatalogBundle\Entity\Product;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Product controller.
 *
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('FoggylineCatalogBundle:Product')->findAll();

        return $this->render('FoggylineCatalogBundle:default:product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new Product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('Foggyline\CatalogBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var $image \Symfony\Component\HttpFoundation\File\UploadedFile */
            if ($image = $product->getImage()) {
                $name = $this->get('foggyline_catalog.image_uploader')->upload($image);
                $product->setImage($name);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('FoggylineCatalogBundle:default:product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('FoggylineCatalogBundle:default:product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        /**
         * When creating a form to edit an already persisted item, the file form type still expects a File instance.
         * As the persisted entity now contains only the relative file path, you first have to concatenate the
         * configured upload path with the stored filename and create a new File class:
         */
        $existingImage = $product->getImage();
        if ($existingImage) {
            $product->setImage(
                new File($this->getParameter('foggyline_catalog_images_directory') . '/' . $existingImage)
            );
        }

        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('Foggyline\CatalogBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /* @var $image \Symfony\Component\HttpFoundation\File\UploadedFile */
            if ($image = $product->getImage()) {
                $name = $this->get('foggyline_catalog.image_uploader')->upload($image);
                $product->setImage($name);
            } elseif ($existingImage) {
                $product->setImage($existingImage);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('FoggylineCatalogBundle:default:product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a Product entity.
     *
     * @param Product $product The Product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
