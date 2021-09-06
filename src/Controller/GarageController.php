<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Garage;
use App\Entity\User;
use App\Repository\AddressRepository;
use App\Repository\GarageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
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
     * @Route("/api/garage/allByUser", name="allGaragesByUser")
     * @Route("/api/garage/allByUser/{id}", name="allGaragesByUserAdmin", requirements={"id"="\d+"})
     */
    public function getAllByUser(User $user=null, UserInterface $currentUser, UserRepository $userRepository)
    {
       if(!$user){
           $userEmail = $currentUser->getUserIdentifier();
           $user = $userRepository->findOneByEmail($userEmail);
       }

        $garages = $user->getGarages();
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
    public function edit(Garage $garage, AddressRepository  $addressRepository,SerializerInterface $serializer, Request $request, EntityManagerInterface $manager):Response
    {

        $data = $request->toArray();

        $addressInput= $data[0];

        $address = $addressRepository->find($addressInput['id']);

        $address->setNumber($addressInput['number'])
            ->setComplement(($addressInput['complement']))
            ->setRoad($addressInput['road'])
            ->setCodePostal($addressInput['codePostal'])
            ->setCity($addressInput['city']);

        $manager->persist($address);
        $manager->flush();


        $garageEdit = $data[1];

        if($garageEdit['name'] != $garage->getName()){
            $garage->setName($garageEdit['name']);
        }

        if($garageEdit['telephone'] != $garage->getTelephone()) {
            $garage->setTelephone($garageEdit['telephone']);
        }


        $manager->persist($garage);
        $manager->flush();
        return  $this->json($garage);
    }
    /**
     *
     * @Route("garage/delete/{id}", name="deleteGarage", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Garage $garage, EntityManagerInterface $manager): Response
    {
        $manager->remove($garage);
        $manager->flush();
        return $this->json("ok");
    }
}

