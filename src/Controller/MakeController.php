<?php

namespace App\Controller;

use App\Entity\Make;
use App\Repository\MakeRepository;
use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MakeController extends AbstractController
{
    /**
     * @Route("/make", name="make")
     */
    public function index(MakeRepository $makeRepository): Response
    {
        $makes =$makeRepository->findAll();
        return $this->json($makes, 200, [], ['groups' => 'makeDisplay']);

    }
    /**
     * @Route("/make/{id}/models", name="modelsByMake")
     */
    public function getModels(Make $make): Response{

        $models = $make->getModels();
        return $this->json($models, 200, [], ['groups' => 'modelsDisplay']);
    }
}
