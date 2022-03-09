<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Form\JeuType;
use App\Repository\JeuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/admin/jeu")
 */
class JeuController extends AbstractController
{
    /**
     * @Route("/", name="jeu_index", methods={"GET"})
     */
    public function index(JeuRepository $repository,Request $request,PaginatorInterface $paginator): Response
    {

        $donnees=$repository->findAll();
        $jeus=$paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            2 // Nombre de résultats par page
        );
        return $this->render('jeu/index.html.twig', [
            'jeus'=>$jeus
        ]);
    }
    /**
     * @Route("/listej", name="jeu_list", methods={"GET"})
     */
    public function listj(JeuRepository $repository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions = $this->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $jeus = $repository->findAll();
        $html = $this->renderView('jeu/listejeu.html.twig', [
            'jeus'=>$jeus ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream("Liste des jeux.pdf", ["Attachment" => false]);
    }





    /**
     * @Route("/new", name="jeu_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jeu = new Jeu();
        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jeu);
            $entityManager->flush();

            return $this->redirectToRoute('jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jeu/new.html.twig', [
            'jeu' => $jeu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jeu_show", methods={"GET"})
     */
    public function show(Jeu $jeu): Response
    {
        return $this->render('jeu/show.html.twig', [
            'jeu' => $jeu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="jeu_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Jeu $jeu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jeu/edit.html.twig', [
            'jeu' => $jeu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jeu_delete", methods={"POST"})
     */
    public function delete(Request $request, Jeu $jeu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jeu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($jeu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('jeu_index', [], Response::HTTP_SEE_OTHER);
    }

    public function set(string $string, string $string1)
    {
    }
}

