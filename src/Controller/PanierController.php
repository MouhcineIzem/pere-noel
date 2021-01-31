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

        $panier = $panierRepository->findUserPanier($this->getUser());

        return $this->render('panier/index.html.twig', [
            'panier' => $panier
        ]);
    }

    /**
     *@Route("/_panier", name="_panier_user")
     */
    public function panier(PanierRepository $panierRepository)
    {
        $panier = $panierRepository->findUserPanier($this->getUser());

        return $this->render('panier/_panier.html.twig', [
            'panier' => $panier
        ]);
    }


    /**
     *@Route("/panier/{id}", name="panier_admin")
     */
    public function indexPanier(PanierRepository $panierRepository, $id, UserRepository $userRepository)
    {
        $panier = $panierRepository->find($id);

       // dd($panier);
        return $this->render('panier/index.html.twig', [
            'panier' => $panier
        ]);
    }

    /**
     * @Route("/panier/new/{cadeauId}", name="new_panier")
     */
    public function newPanier($cadeauId, CadeauRepository $cadeauRepository, PanierRepository $panierRepository)
    {
        $user = $this->getUser();

        $panier = $panierRepository->findOneBy(['person' => $user, 'status' => Panier::STATUS_IN_PROGRESS]);

        if (null === $panier) {
            $panier = new Panier();
            $panier->setPerson($user);
        }

        $cadeau =  $cadeauRepository->findOneById($cadeauId);
        if (null === $cadeau) {
            throw $this->createNotFoundException(sprintf('Cadeaux %d not found', $cadeauId));
        }

        $panier->addCadeaux($cadeau);

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
    public function delete($id,  PanierRepository $panierRepository, CadeauRepository $cadeauRepository)
    {
        $panier = $panierRepository->findUserPanier($this->getUser());

        $cadeau = $cadeauRepository->find($id);

        $panier->removeCadeaux($cadeau);

        if ($panier->getCadeaux()->count() === 0) {
            $this->entityManager->remove($panier);
        }
        $this->entityManager->flush();

        if ($this->getUser()->getRoles() == ["ROLE_USER"]) {
            return $this->redirectToRoute('panier_userConnecte');
        }

        return $this->redirectToRoute('panier_admin', [
            'id' => $panier->getPerson()->getId()
        ]);
    }

}
