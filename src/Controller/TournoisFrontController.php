<?php

namespace App\Controller;

use App\Entity\Tournois;
use App\Repository\TournoisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\Request;


class TournoisFrontController extends AbstractController
{
    /**
     * @Route("/tournois", name="tournois_front")
     */
    public function index(Request $request, TournoisRepository $tournoisRepository, PaginatorInterface $paginator): Response
    {
        $donnees = $tournoisRepository->findAll();

        $tournois = $paginator->paginate(
            $donnees, //
            $request->query->getInt('page', 1),
            3// Nombre de résultats par page
        );

        return $this->render('tournois.html.twig', [
            'tournaments' => $tournois,
        ]);
    }

    /**
     * @Route("/tri", name="tri_date")
     */
    public function TriActionDate(Request $request,TournoisRepository $tournoisRepository, PaginatorInterface $paginator): Response
    {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e FROM App\Entity\Tournois e
    ORDER BY e.Date ASC');
        $events = $query->getResult();
        $tournois = $paginator->paginate(
            $events, //
            $request->query->getInt('page', 1),
            3// Nombre de résultats par page
        );
        return $this->render('tournois.html.twig', array(
            'tournaments' => $tournois));

    }
    /**
     * @Route("/trides", name="tri_datedes")
     */
    public function TriActionDatedes (Request $request,TournoisRepository $tournoisRepository, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e FROM App\Entity\Tournois e
    ORDER BY e.Date DESC');
        $events = $query->getResult();
        $tournois = $paginator->paginate(
            $events, //
            $request->query->getInt('page', 1),
            3// Nombre de résultats par page
        );
        return $this->render('tournois.html.twig', array(
            'tournaments' => $tournois));

    }

    /**
     * @Route("/recherche", name="recherche_event")
     */
    public function searchAction(Request $request, PaginatorInterface $paginator)
    {

        $data = $request->request->get('search');


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT e FROM App\Entity\Tournois e WHERE e.name    LIKE :data')
            ->setParameter('data', '%' . $data . '%');


        $events = $query->getResult();
        //dd($events);
        $evs = $paginator->paginate(
            $events, //
            $request->query->getInt('page', 1),
            3// Nombre de résultats par page
        );

        return $this->render('tournois.html.twig', [
            'tournaments' => $evs,
        ]);

    }

}
