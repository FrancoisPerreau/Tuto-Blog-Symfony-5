<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/inscription", name="security_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User;
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode le mot de passe avant l'enregistrement de l'utilisateur en bdd
            $passwordHash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($passwordHash);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre compte a été créé avec succès');
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/register.html.twig', [
            'pageTitle' => 'Inscription',
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'pageTitle' => 'Connexion',
            'last_username' => $lastUsername,
            'error'  => $error,
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
    }
}
