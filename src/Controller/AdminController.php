<?php

namespace App\Controller;

use App\Form\AgeCategoryType;
use App\Repository\AdresseRepository;
use App\Repository\CadeauRepository;
use App\Repository\PanierRepository;
use App\Repository\UserRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $homme = 0;
        $femme = 0;

        foreach ($panier as $item) {
            if($item->getPerson()->getSexe() == "Homme") {
                $homme ++;
            } else {
                $femme ++;
            }
        }
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['homme',     $homme],
                ['femme',      $femme],
            ]
        );
        $pieChart->getOptions()->setTitle("Porcentage (h|f) qui ont commendés ".$cadeau->getDesignation());
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);




        return $this->render('admin/cadeau_panier.html.twig', [
            'cadeau' => $cadeau,
            'panier' => $panier,
            'piechart' => $pieChart
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

    /**
     *@Route("/pereNoel/categories", name="pereNoel_categories", methods={"GET", "POST"})
     */
    public function categories(PanierRepository $panierRepository, Request $request)
    {
        $panier = $panierRepository->findAll();
        $number = 1;

        $form = $this->createForm(AgeCategoryType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $age = $form->getData();
        }


        $cadeaux = [];
        foreach ($panier as $item) {
            if(!empty($age) and $age > $item->getCadeau()->getAge()) {
                array_push($cadeaux, $item->getCadeau());
            }
            else {
                array_push($cadeaux, $item->getCadeau());
            }
        }

        //dd($cadeaux);


        return $this->render('admin/categories.html.twig', [
            'number' => $number,
            'panier' => $panier,
            'cadeaux' => $cadeaux,
            'form' => $form->createView()
        ]);
    }
}
