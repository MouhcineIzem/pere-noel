<?php

namespace App\Controller;

use App\Repository\AdresseRepository;
use App\Repository\CadeauRepository;
use App\Repository\PanierRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/pereNoel", name="admin_pereNoel")
     */
    public function index(UserRepository $repository, PanierRepository $panierRepository): Response
    {
        $number = 1;
        $users = $repository->findAll();
        $panier = $panierRepository->findOneBy(["person" => $users]);

        return $this->render('admin/index.html.twig', [
            'users' => $users,
            "number" => $number,
            'panier' => $panier
        ]);
    }

    /**
     * @Route("/pereNoel/list/{id}", name="admin_pereNoel_list")
     */
    public function showList($id, UserRepository $userRepository, AdresseRepository $adresseRepository): Response
    {
        $user = $userRepository->findOneById($id);
        $userAdress = $userRepository->findBy(["adresses" => $user->getAdresses()]);

        return $this->render('admin/list-cadeaux.html.twig', [
            'user' => $user,
            'adress' => $userAdress
        ]);
    }

    /**
     *@Route("/pereNoel/adresses", name="pereNoel_adresses")
     */
    public function adressesUsers(UserRepository $userRepository, AdresseRepository  $adresseRepository)
    {
        $users = $userRepository->findAll();
        $villesDupliquées = $adresseRepository->findAll();
        $villes = [];

        $adresses = $adresseRepository->findAll();

        foreach ($villesDupliquées as $v) {
            $villes[] = $v->getVille();
        }


        return $this->render('admin/list_adresses.html.twig', [
            'users' => $users,
            'villes' => array_unique($villes),
            'adresses' => $adresses
        ]);
    }

    /**
     *@Route("/pereNoel/cadeaux", name="pereNoel_cadeaux")
     */
    public function cadeauxUsers(CadeauRepository $cadeauRepository, PanierRepository $panierRepository)
    {
        $number = 1;
        $cadeaux = $cadeauRepository->findAll();
        $panier = $panierRepository->findAll();


        $count = 0;

        /*foreach ($panier as $item) {
            if($item->getCadeau()->getId() == 1)
            {
                $count += 1;
            }
        }
        */
        return $this->render('admin/cadeaux_list.html.twig', [
            'cadeaux' => $cadeaux,
            'number' => $number,
            'panier' => $panier
        ]);
    }

    /**
     *@Route("/pereNoel/cadeaux/cadeau/{id}", name="pereNoel_cadeaux_cadeau")
     */
    public function cadeauDansPanier($id, PanierRepository $panierRepository, CadeauRepository $cadeauRepository)
    {
        $cadeau = $cadeauRepository->findOneById($id);
        $panier = $panierRepository->findBy(["cadeau" => $cadeau]);

        //dd($panier);

        return $this->render('admin/cadeau_panier.html.twig', [
            'cadeau' => $cadeau,
            'panier' => $panier
        ]);
    }

    /**
     *@Route("/pereNoel/commandes", name="pereNoel_commandes")
     */
    public function commandes(PanierRepository $panierRepository)
    {
        $panier = $panierRepository->findAll();
        $number = 1;

        return $this->render('admin/commandes.html.twig', [
            'number' => $number,
            'panier' => $panier
        ]);
    }
}
