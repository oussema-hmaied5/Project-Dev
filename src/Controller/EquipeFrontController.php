<?php

namespace App\Controller;

use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeFrontController extends AbstractController
{
    /**
     * @Route("/equipes", name="equipe_front")
     */
    public function index(EquipeRepository $equipeRepository): Response
    {
        return $this->render('teams.html.twig', [
            'teams' => $equipeRepository->findAll(),
        ]);
    }
}
