<?php

namespace App\Controller;

use App\Entity\Cadeau;
use App\Form\CadeauType;
use App\Repository\CadeauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cadeau")
 */
class CadeauController extends AbstractController
{
    /**
     * @Route("/", name="cadeau_index", methods={"GET"})
     */
    public function index(CadeauRepository $cadeauRepository): Response
    {
        return $this->render('cadeau/index.html.twig', [
            'cadeaus' => $cadeauRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cadeau_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cadeau = new Cadeau();
        $form = $this->createForm(CadeauType::class, $cadeau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cadeau);
            $entityManager->flush();

            return $this->redirectToRoute('cadeau_index');
        }

        return $this->render('cadeau/new.html.twig', [
            'cadeau' => $cadeau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cadeau_show", methods={"GET"})
     */
    public function show(Cadeau $cadeau): Response
    {
        return $this->render('cadeau/show.html.twig', [
            'cadeau' => $cadeau,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cadeau_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cadeau $cadeau): Response
    {
        $form = $this->createForm(CadeauType::class, $cadeau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cadeau_index');
        }

        return $this->render('cadeau/edit.html.twig', [
            'cadeau' => $cadeau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cadeau_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cadeau $cadeau): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cadeau->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cadeau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cadeau_index');
    }
}
