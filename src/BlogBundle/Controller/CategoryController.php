<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Categories;
use BlogBundle\Entity\Tags;
use BlogBundle\Form\CategoriesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CategoryController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $category_report = $em->getRepository("BlogBundle:Categories");
        $category = $category_report->findAll();

        return $this->render('BlogBundle:Default:indexCategory.html.twig', array(
            "category" => $category
        ));
    }

    public function addAction(Request $request)
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();

                $category = new Categories();
                $category->setName($form->get("name")->getData());
                $category->setDescription($form->get("description")->getData());

                $em->persist($category);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La categoria se ha creado correctamente";
                } else {
                    $status = "Error al crear la categoria";
                }

                $status = "Categoria creada correctamente";
            } else {
                $status = "Error al crear la categoria";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("blog_index_category");
        }


        return $this->render('BlogBundle:Default:addCategory.html.twig', array(
            "form" => $form->createView()
        ));
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $category_report = $em->getRepository("BlogBundle:Categories");
        $category = $category_report->find($id);

        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $category->setName($form->get("name")->getData());
                $category->setDescription($form->get("description")->getData());

                $em->persist($category);
                $flush = $em->flush();

                if ($flush == null) {
                    $status = "La categoria se ha editado correctamente";
                } else {
                    $status = "Error al editar la categoria";
                }

                $status = "Categoria editada correctamente";
            } else {
                $status = "Error al editar la categoria";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("blog_index_category");
        }

        return $this->render('BlogBundle:Default:editCategory.html.twig', array(
            "form" => $form->createView()
        ));

    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $category_report = $em->getRepository("BlogBundle:Categories");
        $category = $category_report->find($id);
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute("blog_index_category");
    }
}
