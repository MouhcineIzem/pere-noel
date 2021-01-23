<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/pereNoel", name="admin_pereNoel")
     */
    public function index(UserRepository $repository): Response
    {
        $number = 1;

        return $this->render('admin/index.html.twig', [
            'users' => $repository->findAll(),
            "number" => $number
        ]);
    }
}
