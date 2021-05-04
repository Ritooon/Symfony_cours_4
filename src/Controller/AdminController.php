<?php

namespace App\Controller;

use App\Entity\RechercheVoiture;
use App\Entity\Voiture;
use App\Form\RechercheVoitureType;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(VoitureRepository $repo, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $rechercheVoiture = new RechercheVoiture();

        $form = $this->createForm(RechercheVoitureType::class, $rechercheVoiture);
        $form->handleRequest($request);

        return $this->render('voiture/voitures.html.twig', [
            'voitures' => $paginatorInterface->paginate(
                $repo->findAllWithPagination($rechercheVoiture), 
                $request->query->getInt('page', 1),
                6 
            ),
            'form' => $form->createView(),
            'admin' => true
        ]);
    }

    /**
     * @Route("/admin/creation", name="add_voiture")
     * @Route("/admin/{id}", name="edit_voiture", methods="GET|POST")
     */
    public function modifierVoiture(Voiture $voiture = null, Request $request, EntityManagerInterface $emi): Response
    {
        if(!$voiture) {
            $voiture = new Voiture();
        }

        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $emi->persist($voiture);   
            $emi->flush();   
            $this->addFlash('success', "L'action a bien été effectuée");
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/modification_voiture.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/suppression/{id}", name="del_voiture", methods="DEL")
     */
    public function supprimerVoiture(Voiture $voiture, Request $request, EntityManagerInterface $emi): Response
    {
        if($this->isCsrfTokenValid('DEL'.$voiture->getId(), $request->get('_token'))) {
            $emi->remove($voiture);   
            $emi->flush();   
            $this->addFlash('success', "La suppression a bien été effectuée");
            return $this->redirectToRoute('admin');
        }
    }
}
