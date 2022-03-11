<?php

namespace App\Controller;

use App\Repository\JeuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuFrontController extends AbstractController
{
    /**
     * @Route("/jeux", name="jeu_front")
     */
    public function index(JeuRepository $jeuRepository): Response
    {
        return $this->render('jeux.html.twig', [
            'games' => $jeuRepository->findAll(),
        ]);
    }
}
