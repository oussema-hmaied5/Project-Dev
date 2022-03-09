<?php

namespace App\Controller;

use App\Repository\JeuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuFrontController extends AbstractController
{
    /**
     * @Route("/jeux", name="jeu_front")
     */
    public function index(JeuRepository $repository,Request $request,PaginatorInterface $paginator): Response
    {

        $donnees=$repository->findAll();
        $games=$paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        return $this->render('jeux.html.twig', [
            'games'=>$games
        ]);
    }
    /**
     * @Route("/recherchejeu", name="recherche_jeu")
     */
    public function searchAction(Request $request)
    {

        $data = $request->request->get('search');


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT j FROM App\Entity\Jeu j WHERE j.nom    LIKE :data')
            ->setParameter('data', '%' . $data . '%');


        $events = $query->getResult();
        //dd($events);

        return $this->render('jeux.html.twig', [
            'games' => $events,
        ]);

    }

}
