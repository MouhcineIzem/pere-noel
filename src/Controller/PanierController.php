<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\User;
use App\Repository\CadeauRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private $entityManager;

    /**
     * PanierController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *@Route("/panier", name="panier")
     */
    public function index(PanierRepository $panierRepository)
    {
        $panier = $panierRepository->findBy(["person" => $this->getUser()]);
        //$panier = $panierRepository->findAll();
        //dd($panier);

        return $this->render('panier/index.html.twig', [
            'panier' => $panier
        ]);
    }

    /**
     * @Route("/panier/new/{cadeauId}", name="new_panier")
     */
    public function newPanier($cadeauId, CadeauRepository $cadeauRepository)
    {

        $panier = new Panier();
        $cadeau =  $cadeauRepository->findOneById($cadeauId);
        $user = $this->getUser();

        $panier->setPerson($user);
        $panier->setCadeau($cadeau);

        $this->entityManager->persist($panier);
        $this->entityManager->flush();

       if(!empty($panier)) {
            return $this->redirectToRoute('panier');
       }
       else {
           return new Response("<h1>Panier Vide</h1>");
       }

    }

}
