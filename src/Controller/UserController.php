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
use Symfony\Component\Security\Core\User\UserInterface;
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
     * @Route("/api/user/show", name="show_user", methods={"GET"})
     * @Route("/api/user/show/{id}", name="showUser", requirements={"id"="\d+"})
     *
     */
    public function show(UserInterface $currentUser, User $user = null): Response
    {

        if(!$user){
            $user= $currentUser;
        }
        return $this->json($user, 200, [], ['groups' => 'userDisplay']);
//        $garages = $user->getGarages();
//        return $this->json($user);

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

            $user->setUsername($userEdit->getUsername());

        $manager->persist($user);
        $manager->flush();
        return  $this->json($user);
    }
    /**
     * @Route("api/user/editPassword/{id}", name="editPassword", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function editPassword(User $user, Request $request, UserInterface $currentUser, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager)
    {   $message = "vous n`avez pas perimission pour changer le mot de passe";
        if($user == $currentUser) {
            $data = $request->toArray();
            $currentPasswordSendByUser = $data['currentPassword'];
            if ($hasher->isPasswordValid($currentUser, $currentPasswordSendByUser)) {
                $user->setPassword($data['newPassword']);
                $hashedPassword = $hasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);
                $manager->persist($user);
                $manager->flush();
                $message = "mot de passe changé";
            }
        }
        return $this->json($message);
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
    /**
     * @Route("api/user/test", name = "userTest", methods={"GET"})
     */
    public function test(UserInterface $currentUser){
        $user = $currentUser;
        return $this->json($user, 200, [], ['groups' => 'userDisplay']);
    }

}
