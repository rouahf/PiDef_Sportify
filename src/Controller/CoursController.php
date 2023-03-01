<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\form\type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/cours')]
class CoursController extends AbstractController
{
    #[Route('/', name: 'app_cours_index')]
    public function index(Request $request, CoursRepository $coursRepository): Response
    {
        $nom_cours = $request->query->get('nom_cours');

        if ($nom_cours) {
            $cours = $coursRepository->findByNom_cours($nom_cours);
        } else {
            $cours = $coursRepository->findAll();
        }
    
        return $this->render('cours/index.html.twig', [
            'cours' => $cours,
        ]);
    }

  
    #[Route('/static', name: 'app_cours_static')]
    public function yourAction(EntityManagerInterface $entityManager)
    {
        $totalNumberOfCourses = Cours::getTotalNumberOfCourses($entityManager);
        return $this->render('cours/static.html.twig', [
            'totalNumberOfCourses' => $totalNumberOfCourses
        ]);
    }


    #[Route('/ordnom', name: 'order_By_Nom', methods: ['GET'])]
    public function Torder_By_NomJSON(PaginatorInterface $paginator, CoursRepository $CoursRepository)
    {
      
        return $this->render('cours/index.html.twig', [
            'cours' => $CoursRepository->order_By_Nom(),
        ]);
        
    }
    #[Route('/ordnomF', name: 'order_By_Nomf', methods: ['GET'])]
    public function Torder_By_NomFRONT(Request $request , PaginatorInterface $paginator, CoursRepository $CoursRepository)
    {
        $donnees = $this->getDoctrine()->getRepository(Cours::class)->findAll();
        $cours = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4);
        return $this->render('cours/showF.html.twig', [
            'cours' => $CoursRepository->order_By_Nom(),
        ]);
        
    }
    #[Route('/orddate', name: 'order_By_date', methods: ['GET'])]
    public function Torder_By_DateJSON(PaginatorInterface $paginator, CoursRepository $CoursRepository)
    {
        return $this->render('cours/index.html.twig', [
            'cours' => $CoursRepository->order_By_Date(),
        ]);
        
    }

    #[Route('/front', name: 'app_show', methods: ['GET'])]
    public function showf(Request $request,CoursRepository $coursRepository , PaginatorInterface $paginator): Response
    {
       
        $donnees = $this->getDoctrine()->getRepository(Cours::class)->findAll();
            $cours = $paginator->paginate(
                $donnees, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                4);
          
                



            

        
        return $this->render('cours/showF.html.twig', [
            'cours' => $cours,
            
        ]);
    
    }

    #[Route('/new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CoursRepository $coursRepository,MailerInterface $mailer): Response
    {
        $cour = new Cours();
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new Email())
    ->from('client@gmail.com')
    ->to('adminSportify@yahooo.com')
    ->subject('NOUVEAU COURS !!!!')
    ->html('<p>cours  </p>');

$mailer->send($email);
$this->addFlash(
    'success',
    'Votre demande a été envoyé avec succès');


            $coursRepository->save($cour, true);
          /** @var UploadedFile $uploadedFile */
    $uploadedFile = $form['image']->getData();
    $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
    $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
    $newFile = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
    $uploadedFile->move(
        $destination,
        $newFile
       );
       $cour->setImage($newFile);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($cour);
    $entityManager->flush();

    
   


            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }
         

        return $this->renderForm('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cour, CoursRepository $coursRepository): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursRepository->save($cour, true);

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cour, CoursRepository $coursRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $coursRepository->remove($cour, true);
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }


  
   
    
}
