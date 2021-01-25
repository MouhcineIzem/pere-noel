<?php

namespace App\Controller;

use App\Repository\AdresseRepository;
use App\Repository\CadeauRepository;
use App\Repository\PanierRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        //dd($users);

        foreach ($villesDupliquées as $v) {
            $villes[] = $v->getVille();
        }


        return $this->render('admin/list_adresses.html.twig', [
            'users' => $users,
            'villes' => array_unique($villes)
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



        return $this->render('admin/cadeaux_list.html.twig', [
            'cadeaux' => $cadeaux,
            'number' => $number,
            'panier' => $panier
        ]);
    }
}
