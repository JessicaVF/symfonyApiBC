<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/all", name="userAll")
     */
    public function displayAllUsers(UserRepository $repository, SerializerInterface $serializer): Response
    {
        $users = $repository->findAll();
        return $this->json($users);
    }
    /**
     * @Route("/user/show/{id}", name="showUser", requirements={"id"="\d+"})
     */
    public function show(User $user): Response
    {
        return $this->json($user);
    }
    /**
     * @Route("/user/create", name="createUser", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager):Response
    {


        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        $manager->persist($user);

        $manager->flush();

        return  $this->json($user);
    }
    /**
     * @Route("/user/edit/{id}", name="editUser", methods={"PATCH"})
     */
    public function edit(User $user, SerializerInterface $serializer, Request $request, EntityManagerInterface $manager):Response
    {

        $userEdit = $serializer->deserialize($request->getContent(), User::class, 'json');


        if($userEdit->getFirstname()){
            $user->setFirstname($userEdit->getFirstname());
        }
        if($userEdit->getLastname()){
            $user->setLastname($userEdit->getLastname());
        }
        if($userEdit->getEmail()){
            $user->setEmail($userEdit->getEmail());
        }
        if($userEdit->getTelephone()){
            $user->setTelephone($userEdit->getTelephone());
        }
        if($userEdit->getSiret()){
            $user->setSiret($userEdit->getSiret());
        }

        $user->setLastname($userEdit->getLastname());

        $manager->persist($user);
        $manager->flush();
        return  $this->json($user);
    }
    /**
     *
     * @Route("user/delete/{id}", name="deleteUser", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteUser(User $user, EntityManagerInterface $manager): Response
    {
        $manager->remove($user);
        $manager->flush();
        return $this->json("ok");
    }
}
