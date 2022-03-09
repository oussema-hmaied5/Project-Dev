<?php

namespace App\Controller;

use  App\Repository\TournoisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class TournoisFrontController extends AbstractController
{
    /**
     * @Route("/tournois", name="tournois_front")
     */
    public function index(TournoisRepository $tournoisRepository): Response
    {
        return $this->render('tournois.html.twig', [
            'tournaments' => $tournoisRepository->findAll(),
        ]);
    }

    /**
     * @Route("/tri", name="tri_date")
     */
    public function TriActionDate(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e FROM App\Entity\Tournois e
    ORDER BY e.Date ASC');


        $events = $query->getResult();

        return $this->render('tournois.html.twig', array(
            'tournaments' => $events));

    }
    /**
     * @Route("/trides", name="tri_datedes")
     */
    public function TriActionDatedes(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e FROM App\Entity\Tournois e
    ORDER BY e.Date DESC');


        $events = $query->getResult();

        return $this->render('tournois.html.twig', array(
            'tournaments' => $events));

    }

    /**
     * @Route("/recherche", name="recherche_event")
     */
    public function searchAction(Request $request)
    {

        $data = $request->request->get('search');


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT e FROM App\Entity\Tournois e WHERE e.name    LIKE :data')
            ->setParameter('data', '%' . $data . '%');


        $events = $query->getResult();
        //dd($events);

        return $this->render('tournois.html.twig', [
            'tournaments' => $events,
        ]);

    }

}
