<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthController extends AbstractController
{
    /**
     * @Route("/auth", name="auth")
     */
    public function index(): Response
    {
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
    /**
     * @Route("auth/login", name="login")
     */
    public function login(): Response
    {
        $r ="ok";
        return $this->json($r);
    }
    /**
     * @Route("api/auth/isAdmin", name="isAdmin")
     */
    public function isAdmin(UserInterface $currentUser)
    {

        if(in_array("ROLE_ADMIN", $currentUser->getRoles())){
            return $this->json(true);
        }
        return $this->json(false);
    }
}
