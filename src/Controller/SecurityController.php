<?php 
// src/Controller/SecurityController.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request): Response
    {
        // The login form is handled by the Symfony Security system, 
        // so we don’t need to manually create the form here.
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        // Create a new User instance
        $user = new User();
        $user->setUsername('test')
            ->setPassword($encoder->encodePassword($user, 'password'))
            ->setRoles(['ROLE_USER']);

        // Persist the user to the database
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response('User registered successfully');
    }
}
