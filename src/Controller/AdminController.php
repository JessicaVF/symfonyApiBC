<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\GarageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("admin/quickStats", name="quickStats", methods={"GET"})
     */
    public function quickStats(UserRepository $userRepository, GarageRepository $garageRepository, AnnonceRepository $annonceRepository): Response
    {
        $totalGarages = count($garageRepository->findAll());
        $totalAnnonces = count($annonceRepository->findAll());
        $totalUsers = count($userRepository->findAll());
        $stats = ['totalGarages'=> $totalGarages, 'totalAnnonces'=>$totalAnnonces, 'totalUsers'=>$totalUsers];
        return $this->json($stats);
    }
    /**
     * @Route("admin/allGarages", name="allGarages", methods={"GET"})
     */
    public function allGarages(GarageRepository $garageRepository){
        $garages = $garageRepository->findAll();
//        return $this->json($garages);
        return $this->json($garages, 200, [], ['groups' => 'adminGarageDisplay']);
    }
    /**
     * @Route("admin/allAnnonces", name="allAnnonces", methods={"GET"})
     */
    public function allAnnonces(AnnonceRepository $annonceRepository)
    {
        $annonces = $annonceRepository->findAll();
        return $this->json($annonces, 200, [], ['groups' => 'adminAnnonceDisplay']);
    }
}
