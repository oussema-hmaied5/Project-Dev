<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Commentaire;
use App\Form\ActualiteType;
use App\Form\CommentaireType;
use App\Repository\ActualiteRepository;
use App\Repository\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\Flashy\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actualite")
 */
class ActualiteController extends AbstractController
{
    /**
     * @Route("/", name="app_actualite_index", methods={"GET"})
     */
    public function index(ActualiteRepository $actualiteRepository, CategorieRepository $categorieRepository, PaginatorInterface $paginator,Request $request): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Actualite::class)->findBy([],['updatedAt' => 'desc']);

        $actualite = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1);// Nombre de résultats par page
        return $this->render('actualite/index.html.twig', [
            'actualites' => $actualite,
            'categories' => $categorieRepository->findAll(),

        ]);
    }
    /**
     * @Route("/back", name="app_actualite_back_index", methods={"GET"})
     */
    public function index_back(ActualiteRepository $actualiteRepository,CategorieRepository $categorieRepository): Response
    {
        return $this->render('actualite/back.html.twig', [
            'actualites' => $actualiteRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_actualite_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ActualiteRepository $actualiteRepository): Response
    {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualiteRepository->add($actualite);
            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('actualite/new.html.twig', [
            'actualite' => $actualite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_actualite_show", methods={"GET","POST"})
     */
    public function show(Actualite $actualite, Request $request): Response
    {
        $commentaires = $this->getDoctrine()->getRepository(Commentaire::class)->findBy([
            'actualites'=>$actualite,
            'actif'=>1],
            ['created_at'=>'desc'
            ]);

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $commentaire->setActualites($actualite);
            $commentaire->setCreatedAt(new \DateTime('now'));

            $doctrine = $this->getDoctrine()->getManager();

            $doctrine->persist($commentaire);
            $doctrine->flush();
            $commentaires = $this->getDoctrine()->getRepository(Commentaire::class)->findBy([
                'actualites' => $actualite,
                'actif' => 1
            ],['created_at' => 'desc']);
        }
        return $this->render('actualite/show.html.twig', [
            'actualite' => $actualite,
            'commentaires' => $commentaires,
            'formComment' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_actualite_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Actualite $actualite, ActualiteRepository $actualiteRepository): Response
    {
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualiteRepository->add($actualite);
            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('actualite/edit.html.twig', [
            'actualite' => $actualite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_actualite_delete", methods={"POST"})
     */
    public function delete(Request $request, Actualite $actualite, ActualiteRepository $actualiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualite->getId(), $request->request->get('_token'))) {
            $actualiteRepository->remove($actualite);
        }

        return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * Creates a new ActionItem entity.
     *
     * @Route("/search", name="ajax_search",methods={"GET", "POST"})
     *
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('q');

        $entities =  $em->getRepository('App:Actualite')->findEntitiesByString($requestString);

        if(!$entities) {
            $result['entities']['error'] = "keine Einträge gefunden";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($entities)
    {

        foreach ($entities as $entity) {
            $realEntities[$entity->getId()] = $entity->getTitre();
        }
    }

    /**
     * @Route ("/{id}/pdfactu", name="actu_pdf",methods={"GET"})
     */

    public function pdf($id)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $actualite = $this->getDoctrine()->getRepository(Actualite::class)->findOneBy(['id' => $id]);
        if(!$actualite){
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('actualite/actualitepdf.html.twig', [
            'actualite' => $actualite,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("actualite.pdf", [
            "Attachment" => false
        ]);
    }

}
