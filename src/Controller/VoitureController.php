<?php

namespace App\Controller;

use App\Repository\VoitureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    /**
     * @Route("/client/voitures", name="voitures")
     */
    public function index(VoitureRepository $repo, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        return $this->render('voiture/voitures.html.twig', [
            'voitures' => $paginatorInterface->paginate(
                $repo->findAllWithPagination(), 
                $request->query->getInt('page', 1),
                6 
            )
        ]);
    }
}
