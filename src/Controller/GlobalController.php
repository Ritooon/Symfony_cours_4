<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('global/accueil.html.twig', [
            'controller_name' => 'GlobalController',
        ]);
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $emi, UserPasswordEncoderInterface $encoder): Response
    {
        $utilisateur = new Utilisateur;
        $form = $this->createForm(InscriptionType::class, $utilisateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $crypted = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($crypted);
            $utilisateur->setRoles('ROLE_USER');
            $emi->persist($utilisateur);
            $emi->flush();
            return $this->redirectToRoute('accueil');
        }

        return $this->render('global/inscription.html.twig', [
            'form' => $form->createView()            
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $utils): Response
    {

        return $this->render('global/login.html.twig', [
            'lastUserName' => $utils->getLastUsername(),
            'error' => $utils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {}
    
}
