<?php

namespace App\Controller;

use App\Repository\FuelTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FuelTypeController extends AbstractController
{
    /**
     * @Route("/fueltype", name="fuel_type")
     */
    public function index(FuelTypeRepository $repository): Response
    {
        $fuelTypes= $repository->findAll();
        return $this->json($fuelTypes, 200, [], ['groups' => 'fuelTypeDisplay']);
    }
}
