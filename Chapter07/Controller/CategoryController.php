<?php

namespace Foggyline\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Foggyline\CatalogBundle\Entity\Category;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('FoggylineCatalogBundle:Category')->findAll();

        return $this->render('FoggylineCatalogBundle:default:category/index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/new", name="category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $category = new Category();
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

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('FoggylineCatalogBundle:default:category/show.html.twig', array(
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $category)
    {
        /**
         * When creating a form to edit an already persisted item, the file form type still expects a File instance.
         * As the persisted entity now contains only the relative file path, you first have to concatenate the
         * configured upload path with the stored filename and create a new File class:
         */
        $existingImage = $category->getImage();
        if ($existingImage) {
            $category->setImage(
                new File($this->getParameter('foggyline_catalog_images_directory') . '/' . $existingImage)
            );
        }

        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('Foggyline\CatalogBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /* @var $image \Symfony\Component\HttpFoundation\File\UploadedFile */
            if ($image = $category->getImage()) {
                $name = $this->get('foggyline_catalog.image_uploader')->upload($image);
                $category->setImage($name);
            } elseif ($existingImage) {
                $category->setImage($existingImage);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_edit', array('id' => $category->getId()));
        }

        return $this->render('FoggylineCatalogBundle:default:category/edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('category_index');
    }

    /**
     * Creates a form to delete a Category entity.
     *
     * @param Category $category The Category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
