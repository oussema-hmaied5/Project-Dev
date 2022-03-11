<?php

namespace App\Controller;

use App\Entity\Tournois;
use App\Form\TournoisType;
use App\Repository\TournoisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tournois")
 */
class TournoisController extends AbstractController
{
    /**
     * @Route("/", name="tournois_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator) // Nous ajoutons les paramètres requis
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Tournois::class)->findAll();

        $tournois = $paginator->paginate(
            $donnees, //
            $request->query->getInt('page', 1),
            3// Nombre de résultats par page
        );

        return $this->render('tournois/index.html.twig', [
            'tournois' => $tournois
        ]);
    }


    /**
     * @Route("/calendrier/", name="tournois_calendrier", methods={"GET"})
     */
    public function calendar_back(Request $request) // Nous ajoutons les paramètres requis
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Tournois::class)->findAll();

        $res = [];
        foreach($donnees as $tournoi)
        {
            $res[] = [
                'id'=> $tournoi->getId(),
                'start'=> $tournoi->getDate()->format('Y-m-d H:i:s'),
                'end'=> $tournoi->getDate()->format('Y-m-d H:i:s'),
                // 'title'=> $reservation->getIdReservable()->getLoisir()->getTitle(),
                'title'=> $tournoi->getName(),
            ];
        }

        $data = json_encode($res);

        return $this->render('tournois/calendrier.html.twig', [
            'data' => $data
        ]);
    }

    /**
     * @Route("/tournoipdf", name="tournois_pdf", methods={"GET"})
     */
    public function tournoipdf (TournoisRepository $tournoisRepository)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $tournois =$tournoisRepository->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('tournois/tournoipdf.html.twig',
            ['tournois' => $tournois]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Liste des tournois.pdf", [
            "Attachment" => true
        ]);

    }
    /**
     * @Route("/new", name="tournois_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tournoi = new Tournois();
        $form = $this->createForm(TournoisType::class, $tournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tournoi);
            $entityManager->flush();

            return $this->redirectToRoute('tournois_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tournois/new.html.twig', [
            'tournoi' => $tournoi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tournois_show", methods={"GET"})
     */
    public function show(Tournois $tournoi): Response
    {
        return $this->render('tournois/show.html.twig', [
            'tournoi' => $tournoi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tournois_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tournois $tournoi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TournoisType::class, $tournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tournois_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tournois/edit.html.twig', [
            'tournoi' => $tournoi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tournois_delete", methods={"POST"})
     */
    public function delete(Request $request, Tournois $tournoi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tournoi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tournoi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tournois_index', [], Response::HTTP_SEE_OTHER);
    }
    public function page(Request $request, PaginatorInterface $paginator) // Nous ajoutons les paramètres requis
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Tournois::class)->findBy([],['created_at' => 'desc']);

        $tournaments = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );

        return $this->render('tournois/index.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }


}
