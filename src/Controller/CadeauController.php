<?php

namespace App\Controller;

use App\Model\Search;
use App\Entity\Cadeau;
use App\Form\CadeauType;
use App\Form\SearchType;
use App\Repository\CadeauRepository;
use App\Repository\CategorieRepository;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    public function index(CadeauRepository $cadeauRepository, Request $request, CategorieRepository $categorieRepository, PanierRepository  $panierRepository): Response
    {
        $cadeaux = $cadeauRepository->findAll();
        $categories = $categorieRepository->findAll();

        $panier = $panierRepository->findBy(["person" => $this->getUser()]);


        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $cadeaux = $cadeauRepository->findWithSearch($search);

        }

        return $this->render('cadeau/index.html.twig', [
            'cadeaus' => $cadeaux,
            'categories' => $categories,
            'panier' => $panier,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="cadeau_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $cadeau = new Cadeau();
        $form = $this->createForm(CadeauType::class, $cadeau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            //dd($image);

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                try {
                    $image->move(
                      $this->getParameter('images_cadeaux'),
                        $newFilename
                    );
                } catch (FileException $exception) {
                    // handle an Exception
                }

                $cadeau->setImage($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $cadeau->setUser($this->getUser());
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
    public function show(Cadeau $cadeau, PanierRepository  $panierRepository): Response
    {
        $panier = $panierRepository->findBy(["person" => $this->getUser()]);
        return $this->render('cadeau/show.html.twig', [
            'cadeau' => $cadeau,
            'panier' => $panier
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
