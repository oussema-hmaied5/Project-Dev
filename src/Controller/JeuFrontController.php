<?php

namespace App\Controller;

use App\Repository\JeuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;
use App\Services\QrcodeService;

class JeuFrontController extends AbstractController
{

    /**
     * @Route("/recherchejeu", name="recherche_jeu")
     */
    public function searchAction(Request $request, PaginatorInterface $paginator,QrcodeService $qrcodeService)
    {

        $data = $request->request->get('search');


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT j FROM App\Entity\Jeu j WHERE j.nom    LIKE :data')
            ->setParameter('data', '%' . $data["name"] . '%');


        $events = $query->getResult();
        //dd($events);
        $games = $paginator->paginate(
            $events, //
            $request->query->getInt('page', 1),
            3// Nombre de résultats par page
        );

        $qrCode = null;
        $form = $this->createForm(SearchType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $qrCode = $qrcodeService->qrcode($data['name']);

        }
        return $this->render('jeux.html.twig', [
            'games' => $games,
            'form' => $form->createView(),
            'qrCode' => $qrCode,
        ]);

    }
    /**
     * @Route("/jeux", name="jeu_front")
     * @param Request $request
     * @param QrcodeService $qrcodeService
     * @return Response
     */
    public function qr(Request $request, QrcodeService $qrcodeService,JeuRepository $repository,PaginatorInterface $paginator): Response
    {
        $donnees=$repository->findAll();
        $games=$paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );
        $qrCode = null;
        $form = $this->createForm(SearchType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $qrCode = $qrcodeService->qrcode($data['name']);

        }

        return $this->render('jeux.html.twig', [
            'form' => $form->createView(),
            'qrCode' => $qrCode,
            'games' =>$games,
        ]);
    }


}
