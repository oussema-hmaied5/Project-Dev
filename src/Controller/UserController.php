<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;

use App\Repository\UserRepository;
use App\Services\QrcodeService;

use Dompdf\Dompdf;
use Dompdf\Options;;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;





class UserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/afficheuser", name="afficheuser")
     */
    public function affiche()
    {
        $repository = $this->getDoctrine()->getrepository(User::Class);//recuperer repisotory
        $users = $repository->findAll();//affichage
        return $this->render('user\index.html.twig', [
            'users' => $users,
        ]);//liasion twig avec le controller
    }


    /**
     * @Route("/Ajouteuser", name="Ajouteuser")
     */
    public function ajouter(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $users = new User();//creation instance
        $form = $this->createForm(UserType::class, $users);//Récupération du formulaire dans le contrôleur:
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();//recupuration entity manager
           //encode the plain password
            $users->setPassword(
                $passwordEncoder->encodePassword(
                    $users, $users->getPassword())
            );


            $em->persist($users);//l'ajout de la objet cree
            $em->flush();

            return $this->redirectToRoute('app_login');
            //redirecter la pagee la page dafichage
        }

        return $this->render('front\ajout.html.twig', [
            'form' => $form->createview()
        ]);

    }


    /**
     * @Route("user/supp/{id}", name="d")
     */
    public function supprimer ($id)
    {
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);//suprrimer lobjet dans le parametre
        $em->flush();
        return $this->redirectToRoute('afficheuser');

    }
    /**
     * @route ("user/modifier/{id}", name="u")
     */
    function modifier(UserRepository $repository,Request $request,$id)
    {
        $users = $repository->find($id);
        $form = $this->createForm(UserType::class, $users);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheuser');
        }
        return $this->render('user/modifier.html.twig', [
            'form' => $form->createView()
        ]);

    }




    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('final.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }


    /**
     * @Route("/back", name="back")
     */
    public function back(): Response
    {
        return $this->render('Global.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    /**
     * @Route("/pdf1/{id} ", name="pdf1")
     * @param QrcodeService
     */
    public function pdf(UserRepository $Repository,QrcodeService $qrcodeService,$id)
    {
        $qrCode = null ;


        $users = $Repository->find($id);
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('user\pdf1.html.twig', [
            'title' => "Welcome to our PDF Test",
            'users' =>$users
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("la liste des Utilisateur.pdf", [
            "Attachment" => true
        ]);
         if ($form->isSubmitted() && $form ->isValid()){

             $date = $form->getData ();
          $qrCode=   $qrcodeService->qrcode($date ['name']);
         }

        return $this->render('user/pdf1.html.twig',[
            'U'=>$users ,
            'qrcode'=>$qrCode


        ]);
    }


    /**
     * @route ("user\search", name="search")
     */
    function searchTitle(UserRepository $repository,Request $request )
    {
        $data1=$request->get('find1');
        $data2=$request->get('find2');
        $users=$repository->findBy(array('nom'=>$data1,'prenom'=>$data2));
        return $this->render('user\index.html.twig', [
            'users' => $users,
        ]);


    }
    /**
     * @Route ("admin/triup", name="croissant")
     */
    public function orderSujetASC(UserRepository  $repository){

        $plans=$repository->triSujetASC();
        return $this->render('user/index.html.twig', [
            'users' => $plans
        ]);
    }

    /**
     * @Route("admin/tridown", name="decroissant")
     */
    public function orderSujetDESC(UserRepository $repository){

        $plans=$repository->triSujetDESC();
        return $this->render('user/index.html.twig', [
            'users' => $plans
        ]);
    }
    /**
     * @Route("/SearchUserx ", name="SearchUserx")
     */
    public function searchUserx(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $requestString=$request->get('searchValue');
        $students = $repository->findUsereByNom($requestString);
        $jsonContent = $Normalizer->normalize($students, 'json',['groups'=>'Oussema']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }

}
