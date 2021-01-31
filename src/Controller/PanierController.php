<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\User;
use App\Repository\CadeauRepository;
use App\Repository\PanierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     *@Route("/panier", name="panier_userConnecte")
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
     *@Route("/panier/{id}", name="panier_admin")
     */
    public function indexPanier(PanierRepository $panierRepository, $id, UserRepository $userRepository)
    {

        $user = $userRepository->findById($id);
        //dd($user);
        $panier = $panierRepository->findBy(["person" => $user]);

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
            return $this->redirectToRoute('panier_userConnecte');
       }
       else {
           return new Response("<h1>Panier Vide</h1>");
       }

    }

    /**
     * @Route("/panier/delete/{id}", name="panier_delete_from_list")
     */
    public function delete(Request $request,$id,  PanierRepository $panierRepository, Panier $panier)
    {
        $panier = $panierRepository->findOneById($id);

        //dd($panier);

        //$user = $userRepository->findById($id);
        //dd($user);
        //$panier = $panierRepository->findBy(["person" => $user]);

            $this->entityManager->remove($panier);
            $this->entityManager->flush();

        if ($this->getUser()->getRoles() == ["ROLE_USER"]) {
            return $this->redirectToRoute('panier_userConnecte');
        }

        return $this->redirectToRoute('panier_admin', [
            'id' => $panier->getPerson()->getId()
        ]);


    }

}
