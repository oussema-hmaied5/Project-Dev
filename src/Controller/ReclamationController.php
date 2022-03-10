<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\User;
use App\Form\ReclamationType;
use App\Form\UserType;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use App\Services\QrcodeService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ReclamationController extends AbstractController
{
    /**
     * @Route("/Ajoutereclamation/add/{id}", name="Ajoutereclamation", methods={"GET","POST"})
     */
    public function ajouter(Request $request, $id, UserRepository $repository)
    {
        $user=$repository->find($id);

        $reclamations = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamations);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $reclamations->setStatut('Encours') ;
            $reclamations->setMail($user->getEmail());
            $reclamations->setNum($user->getNum());
            $reclamations->setUser($user) ;
            $em = $this->getDoctrine()->getManager();//recupuration entity manager
            $em->persist($reclamations);//l'ajout de la objet cree
            $em->flush();
            return $this->redirectToRoute('home');//redirecter la pagee la page dafichage
        }

        return $this->render('reclamation\ajouter.html.twig', [
            'reclamation' => $reclamations,
            'form' => $form->createview()
        ]);



        $offre=$repository->find($id);
        $demande->setRelatedOffre($offre);


    }




    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/affichereclamation", name="affichereclamation")
     */
    public function affiche()
    {
        $repository = $this->getDoctrine()->getrepository(Reclamation::Class);//recuperer repisotory
        $reclamation = $repository->findAll();//affichage
        return $this->render('reclamation\reclamation.html.twig', [
            'reclamation' => $reclamation,
        ]);//liasion twig avec le controller
    }
    /**
     * @Route("/supp/{id}", name="s")
     */
    public function supprimer ($id)
    {
        $reclamations=$this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($reclamations);//suprrimer lobjet dans le parametre
        $em->flush();
        return $this->redirectToRoute('affichereclamation');

    }

    /**

     * @Route("/afficher", name="afficher")
     */
    public function afficher()
    {
        $repository = $this->getDoctrine()->getrepository(Reclamation::Class);//recuperer repisotory
        $reclamation = $repository->findAll();//affichage
        return $this->render('front\afficher.html.twig', [
            'reclamation' => $reclamation,
        ]);//liasion twig avec le controller
    }
    /**
     * @Route("/pdf/{id} ", name="pdf")
     * @param QrcodeService
     */
    public function pdf(ReclamationRepository $Repository,QrcodeService $qrcodeService,$id)
    {
        $qrCode = null ;

        $reclamation = $Repository->find($id);
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reclamation/pdf.html.twig', [
            'title' => "Welcome to our PDF Test",
            'reclamation' =>$reclamation
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("la liste de Reclamation.pdf", [
            "Attachment" => true
        ]);
        if ($form->isSubmitted() && $form ->isValid()){

            $date = $form->getData ();
            $qrCode=   $qrcodeService->qrcode($date ['name']);
        }

        return $this->render('reclamation/show.html.twig', [
            'r' => $reclamation,
            'qrcode'=>$qrCode
        ]);
    }
    /**
     *
     * @Route ("/mail/{id}", name="mail")
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function Mailing(\Swift_Mailer $mailer,$id,ReclamationRepository $Repository)
    {
        $repository = $this->getDoctrine()->getrepository(Reclamation::Class);
        $reclamations = $repository->findBy(
            ['id' => $id]
        );
        $message = (new \Swift_Message('Service Reclamations E-prog'))
            ->setFrom('oussema.hmaied1@esprit.tn')
            ->setTo('oussama.hamaied@gmail.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'reclamation/mailo.html.twig',
                    ['reclamations' => $reclamations]
                ),
                'text/html'

            );

        $mailer->send($message);

        $this->addFlash('message','le message a bien été envoyer');

        return $this->redirectToRoute('affichereclamation',[
            'id' => $id
        ]);


    }
    /**

     * @Route("/Reclamation/find/{id}", name="z")
     */
    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $Reclamation = $em->getRepository(Reclamation::class)->findEntitiesByString($requestString);
        if(!$Reclamation)
        {
            $result['Reclamation']['error']="Reclamation introuvable  ";

        }else{
            $result['Reclamation']=$this->getRealEntities($Reclamation);
        }
        return new Response(json_encode($result));

    }
    public function getRealEntities($Reclamation){
        foreach ($Reclamation as $Reclamation){
            $realEntities[$Reclamation->getId()] = [$Reclamation->getObject(), $Reclamation->getDescription(),$Reclamation->getStatut()];
        }
        return $realEntities;
    }


}



