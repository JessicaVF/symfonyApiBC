<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Garage;
use App\Repository\GarageRepository;
use App\Repository\UserRepository;
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
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, UserRepository $userRepository):Response
    {

        $data = $request->toArray();
        $addressInput= $data[0];

        $address = new Address();
        $address->setNumber($addressInput['number'])
                ->setRoad($addressInput['road'])
                ->setCodePostal($addressInput['code_postal'])
                ->setCity($addressInput['city']);
        if($addressInput['complement'] != ""){
            $address->setComplement($addressInput['complement']);
        }

        $manager->persist($address);

        $manager->flush();

        $garageInfo = $serializer->serialize($data[1], 'json');

        $garage = $serializer->deserialize($garageInfo, Garage::class, 'json');

        $garage->setAddress($address);

        //dummy user a la place de current user
        $user = $userRepository->find('2');
        $garage->setUser($user);

        $manager->persist($garage);

        $manager->flush();

        return  $this->json($garage);
    }
    /**
     * @Route("/garage/edit/{id}", name="editGarage", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function edit(Garage $garage, SerializerInterface $serializer, Request $request, EntityManagerInterface $manager):Response
    {
        $garageEdit = $serializer->deserialize($request->getContent(), Garage::class, 'json');

        if($garageEdit->getName()){
            $garage->setName($garageEdit->getName());
        }
        if($garageEdit->getTelephone()){
            $garage->setTelephone($garageEdit->getTelephone());
        }
        // aca habra que maniobrar con las address

        $manager->persist($garage);
        $manager->flush();
        return  $this->json($garage);
    }
    /**
     *
     * @Route("garage/delete/{id}", name="deleteGarage", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteUser(Garage $garage, EntityManagerInterface $manager): Response
    {
        $manager->remove($garage);
        $manager->flush();
        return $this->json("ok");
    }
}

