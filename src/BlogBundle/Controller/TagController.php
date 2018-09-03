<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Tags;
use BlogBundle\Form\TagsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class TagController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $tag_report = $em->getRepository("BlogBundle:Tags");
        $tags = $tag_report->findAll();

        return $this->render('BlogBundle:Default:indexTag.html.twig', array(
            "tags" => $tags
        ));
    }

    public function addAction(Request $request)
    {
        $tag = new Tags();
        $form = $this->createForm(TagsType::class, $tag);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();

                $tag = new Tags();
                $tag->setName($form->get("name")->getData());
                $tag->setDescription($form->get("description")->getData());

                $em->persist($tag);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La etiqueta se ha creado correctamente";
                } else {
                    $status = "Error al etiquetar en la etiqueta";
                }

                $status = "Tag creado correctamente";
            } else {
                $status = "Error al crear el tag";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("blog_index_tag");
        }


        return $this->render('BlogBundle:Default:addTag.html.twig', array(
            "form" => $form->createView()
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $tag_report = $em->getRepository("BlogBundle:Tags");
        $tag = $tag_report->find($id);
        $em->remove($tag);
        $em->flush();

        return $this->redirectToRoute("blog_index_tag");
    }
}
