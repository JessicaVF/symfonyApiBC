<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/all", name="userAll")
     */
    public function displayAllUsers(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        return $this->json($users);
    }
    /**
     * @Route("/user/show/{id}", name="showUser", requirements={"id"="\d+"})
     */
    public function show(User $user): Response
    {
        return $this->json($user, 200, [], ['groups' => 'userDisplay']);
    }
    /**
     * @Route("/user/create", name="createUser", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher):Response
    {

        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        $hashedPassword = $hasher->hashPassword($user, $user->getPassword());

        $user->setPassword($hashedPassword);

        $manager->persist($user);

        $manager->flush();

        return  $this->json($user);
    }
    /**
     * @Route("/user/edit/{id}", name="editUser", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function edit(User $user, SerializerInterface $serializer, Request $request, EntityManagerInterface $manager):Response
    {

        $userEdit = $serializer->deserialize($request->getContent(), User::class, 'json');


            $user->setFirstname($userEdit->getFirstname());

            $user->setLastname($userEdit->getLastname());

            $user->setEmail($userEdit->getEmail());

            $user->setTelephone($userEdit->getTelephone());

            $user->setSiret($userEdit->getSiret());

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
