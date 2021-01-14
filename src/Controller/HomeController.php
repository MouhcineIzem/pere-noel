<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response as BrowserKitResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/list", name="app_list")
     */
    public function lister(): Response
    {
        return $this->render('home/list.html.twig');
    }

    /**
     * @Route("/list_cadeaux", name="app_list_cadeaux")
     */
    public function listerLesCadeaux() {

        return $this->render('home/liste_cadeaux.html.twig');
    }




}
