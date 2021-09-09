<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\FuelType;
use App\Entity\User;
use App\Repository\AnnonceRepository;
use App\Repository\FuelTypeRepository;
use App\Repository\GarageRepository;
use App\Repository\MakeRepository;
use App\Repository\ModelRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce/all", name="annonceAll", methods={"GET"})
     */
    public function index(AnnonceRepository $repository, SerializerInterface $serializer): Response
    {

       $annonces = $repository ->findBy(array(), array('id' => 'desc'));
//        return $this->json($annonces);
        return $this->json($annonces, 200, [], ['groups' => 'annonceDisplay']);
    }
    /**
     * @Route("/api/annonce/allByUser", name="allAnnoncesByUser")
     * @Route("/api/annonce/allByUser/{id}", name="allAnnoncesByUserAdmin", requirements={"id"="\d+"})
     */
    public function getAllByUser(User $user=null, UserInterface $currentUser, UserRepository $userRepository)
    {
        if(!$user){
            $userEmail = $currentUser->getUserIdentifier();
            $user = $userRepository->findOneByEmail($userEmail);
        }

        $annonces = $user->getAnnonces();
        return $this->json($annonces, 200, [], ['groups' => 'annonceDisplay']);

    }
    /**
     * @Route("/annonce/show/{id}", name="showAnnonce", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function show(Annonce $annonce): Response
    {
        return $this->json($annonce, 200, [], ['groups' => 'annonceDisplay']);

    }
    /**
     * @Route("/annonce/create", name="createAnnonce", methods={"POST"})
     */
    public function create(GarageRepository $garageRepository, UserRepository $userRepository, MakeRepository $makeRepository, ModelRepository $modelRepository, FuelTypeRepository $fuelTypeRepository, Request $request, SerializerInterface $serializer, EntityManagerInterface $manager):Response
    {

        $data = $request->toArray();
        $dataToRetrieve= $data[0];

        $make = $makeRepository->find($dataToRetrieve['make']);
        $model = $modelRepository->find($dataToRetrieve['model']);
        $user = $userRepository->find($dataToRetrieve['user']);
        $garage = $garageRepository->find($dataToRetrieve['garage']);
        $fuelType = $fuelTypeRepository->find($dataToRetrieve['fuelType']);

        $annonceInfo = $serializer->serialize($data[1], 'json');
        $annonce = $serializer->deserialize($annonceInfo, Annonce::class, 'json');

        $annonce->setMake($make);
        $annonce->setModel($model);
        $annonce->setAuthor($user);
        $annonce->setGarage($garage);
        $annonce->setfuelType($fuelType);

        $manager->persist($annonce);
        $manager->flush();

        return  $this->json($annonce);
    }
    /**
     * @Route("/annonce/edit/{id}", name="editAnnonce", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function edit(Annonce $annonce, SerializerInterface $serializer, Request $request, EntityManagerInterface $manager):Response
    {

        $annonceEdit = $request->toArray();
        $annonce->setTitle($annonceEdit['title'])
                ->setDescription($annonceEdit['description'])
                ->setShortDescription($annonceEdit['shortDescription'])
                ->setPrice($annonceEdit['price'])
                ->setCirculationYear($annonceEdit['circulationYear'])
                ->setKilometers($annonceEdit['kilometers'])
                ->setPhotos($annonceEdit['photos']);

        $manager->persist($annonce);
        $manager->flush();
        return  $this->json($annonce);
    }
    /**
     *
     * @Route("annonce/delete/{id}", name="deleteAnnonce", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Annonce $annonce, EntityManagerInterface $manager): Response
    {
        $manager->remove($annonce);
        $manager->flush();
        return $this->json("ok");
    }
    /**
     * @Route("annonce/search", name="searchAnnonce", methods={"POST"})
     */
    public function search(Request $request, AnnonceRepository $repository):Response
    {
        $data = $request->toArray();

        $annonces = $repository->findAllByUserSelection($data['make'], $data['model'], $data['fuelType'], $data['kilometers'], $data['circulationYear'], $data['price'] );

        return $this->json($annonces, 200, [], ['groups' => 'annonceDisplay']);

    }
}
