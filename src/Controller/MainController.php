<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/email')]
    public function __construct(private MailerInterface $mailer) {}
    

    public function sendEmail($to='maher.karoui@esprit.tn'): void
    {
        $email = (new Email())
            ->from('maher.karoui@example.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);

        // ...
    }
  /*  #[Route("/stat/{id}", name="article_show_")]
    public function showCom(Articles $article): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
    $queryBuilder = $entityManager->createQueryBuilder();

    $count = $queryBuilder->select('COUNT(c.id)')
        ->from('App\Entity\Cours', 'c')
        ->setParameter('id', $cours)
        ->getQuery()
        ->getSingleScalarResult();

    $responseData = [
        'cours' => $cours->getId(),
        'count' => $count,
    ];

    return new JsonResponse($responseData);
    } 
}


    public function sendEmail(MailerInterface $mailer,Request $request,Cours $cours): Response
    {
        $form =$this->createForm(SendMailType::class,null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $message=$form->get('nom_cours')->getData();
            $subject=$form->get('activite')->getData();
            $email = (new Email())
                ->from('dhaou.amri@esprit.tn')
                ->to('maher.karoui@esprit.tn')
                ->subject((string)$subject)
                ->text('Sending emails is fun again!')
                ->html("<p>$message</p>");
            $mailer->send($email);
            $this->addFlash('success', 'votre email a ete bien envoyé');
            return $this->redirectToRoute('cours_index');
        }
        return $this->render('admin/sendMail.html.twig', ['form' => $form->createView()]);
    }
}*/

}