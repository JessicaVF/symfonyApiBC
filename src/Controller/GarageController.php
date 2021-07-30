<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Repository\GarageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GarageController extends AbstractController
{
    /**
     * @Route("/garage/all", name="garageAll")
     */
    public function displayAllGarages (GarageRepository $repository, SerializerInterface $serealizer): Response
    {
        $garages = $repository->findAll();
        return $this->json($garages, 200, [], ['groups' => 'garageDisplay']);
    }
    /**
     * @Route("/garage/show/{id}", name="showGarage", requirements={"id"="\d+"})
     */
    public function show(Garage $garage): Response
    {
        return $this->json($garage, 200, [], ['groups' => 'garageDisplay']);
    }
    /**
     * @Route("/garage/create", name="createGarage", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager):Response
    {

        $garage = $serializer->deserialize($request->getContent(), Garage::class, 'json');

        $manager->persist($garage);

        $manager->flush();

        return  $this->json($garage);
    }
}

