<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce/all", name="annonceAll")
     */
    public function index(AnnonceRepository $repository, SerializerInterface $serializer): Response
    {
        $annonce = $repository->findAll();
        return $this->json($annonce);
    }
    /**
     * @Route("/annonce/show/{id}", name="showAnnonce", requirements={"id"="\d+"})
     */
    public function show(Annonce $annonce): Response
    {
        return $this->json($annonce);
    }
    /**
     * @Route("/annonce/create", name="createAnnonce", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager):Response
    {

        $annonce = $serializer->deserialize($request->getContent(), Annonce::class, 'json');

        $manager->persist($annonce);

        $manager->flush();

        return  $this->json($annonce);
    }
    /**
     * @Route("/annonce/edit/{id}", name="editAnnonce", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function edit(Annonce $annonce, SerializerInterface $serializer, Request $request, EntityManagerInterface $manager):Response
    {

        $annonceEdit = $serializer->deserialize($request->getContent(), Annonce::class, 'json');


        $manager->persist($annonce
        );
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
}
