<?php

namespace App\Controller;
use App\Entity\Commentaires;
use App\Entity\Articles;
use App\Entity\PostLike;
use App\Entity\Utilisateur;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use App\Repository\CommentairesRepository;
use App\Repository\PostLikeRepository;
use App\Service\PdfService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


use DateTime;

#[Route('/articles')]

class ArticlesController extends AbstractController{
    
    public function __construct(FlashyNotifier $flashy)
    {
        $this->flashy = $flashy;
    }
    #[Route('/', name: 'app_articles_index', methods: ['GET'])]
    public function index(ArticlesRepository $articlesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // On récupère tous les articles
        $articles = $articlesRepository->findAll();
    
        // On pagine les résultats
        $articlesPaginated = $paginator->paginate(
            $articles, // Les résultats à paginer
            $request->query->getInt('page', 1), // Numéro de page par défaut
            3 // Nombre d'éléments par page
        );
    
        // On rend le résultat en utilisant la méthode render()
        return $this->render('articles/index.html.twig', [
            'articles' => $articlesPaginated, // On passe les articles paginés à la vue
            '_flash_messages' => $this->flashy->success('Welcome!', 'http://your-awesome-link.com'),
        ]);
    }
    //Dans cet exemple, nous paginons les résultats de la requête en utilisant $paginator->paginate(), puis nous passons les résultats paginés à la vue en utilisant 'articles' => $articlesPaginated. Nous passons également le message flash en utilisant $this->flashy->success().
    
    
    
    
    
    

    
    
    #[Route('/new', name: 'app_articles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticlesRepository $articlesRepository): Response
    {
$article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $article-> setDateA(new \DateTime('now'));
        $form->handleRequest($request);
      
       /** @var UploadedFile $uploadedFile */
       if ($form->isSubmitted() && $form->isValid()) {
$uploadedFile = $form['image_article']->getData();
$destination = $this->getParameter('kernel.project_dir').'/public/uploads';
$originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
$newFile = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
$uploadedFile->move(
    $destination,
    $newFile
   );
   $article->setImageArticle($newFile);
   $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($article);
    $entityManager->flush();

        



       if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->save($article, true);

            return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
        }
       
    }
    // On définit le message flash de succès
$successMessage = $this->flashy->success('article ajouté!', 'http://your-awesome-link.com');
        return $this->renderForm('articles/new.html.twig',  [
            'article' => $article,
            'form' => $form,
            '_flash_messages' => $successMessage,
        ]);
    
    }
    #[Route('/{id}', name: 'app_articles_show', methods: ['GET'])]
    public function show(Articles $article): Response
    {
        
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_articles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);
  /** @var UploadedFile $uploadedFile */
  if ($form->isSubmitted() && $form->isValid()) {
    $uploadedFile = $form['image_article']->getData();
    $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
    $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
    $newFile = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
    $uploadedFile->move(
        $destination,
        $newFile
       );
       $article->setImageArticle($newFile);
       $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
    
    
        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->save($article, true);

            return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
        }
    }
        return $this->renderForm('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_articles_delete', methods: ['POST'])]
    public function delete(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articlesRepository->remove($article, true);
            
        }
        return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);

    }

   /* #[Route('/stat', name: 'app_stat', methods: ['GET', 'POST'])]
    public function stats(ArticlesRepository $serviceRepository, CommentairesRepository $appointmentRepository): Response
    {
        $services = $serviceRepository->findAll();
        $appointments = $appointmentRepository->findAll();

        // Calculer le nombre de rendez-vous pour chaque service
        $appointmentsByService = array();
        foreach ($services as $service) {
            $appointmentsByService[$service->nblike()] = 0;
            foreach ($appointments as $appointment) {
                if ($appointment->getIdArticle() === $service) {
                    $appointmentsByService[$service->nblike()]++;
                }
            }
        }

        return $this->render('stats.html.twig', [
            'services' => $services,
            'appointmentsByService' => $appointmentsByService,
            'appointmentsCount' => count($appointments),
        ]);
    }
*/

    
    //Exporter pdf (composer require dompdf/dompdf)
    #[Route('/generate-pdf/{id}', name: 'app_generate_pdf_article')]
    public function generatePdf(Request $request, Articles $articles,FlashyNotifier $flashy)
    {
        // Generate the PDF content
        $html = $this->renderView('articles/pdf.html.twig', [
            'articles' => [$articles],
        ]);
        $flashy->success('pdf Generé', 'http://your-awesome-link.com');

        // Instantiate the dompdf class and render the HTML
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Set the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();
        // Return the PDF as a response
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'articles/pdf',
            'Content-Disposition' => 'inline; filename="article.pdf"',
        ]);
    }

}