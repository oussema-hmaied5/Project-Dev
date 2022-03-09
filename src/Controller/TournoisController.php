<?php

namespace App\Controller;

use App\Entity\Tournois;
use App\Form\TournoisType;
use App\Repository\TournoisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tournois")
 */
class TournoisController extends AbstractController
{
    /**
     * @Route("/", name="tournois_index", methods={"GET"})
     */
    public function index(TournoisRepository $tournoisRepository): Response
    {
        return $this->render('tournois/index.html.twig', [
            'tournois' => $tournoisRepository->findAll(),
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
}
