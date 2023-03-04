<?php


namespace App\Controller;

use App\Repository\CoursRepository;
use App\Entity\Reclamationn;
use App\Form\ReclamationnType;
use App\Repository\ReclamationnRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Dompdf\Dompdf;



class PdfController extends AbstractController
{
    #[Route('/generate-pdf/{id}', name: 'app_generate_pdf')]
    public function generatePdf(Request $request, Reclamationn $Reclamationn)
    {
        // Generate the PDF content
        $html = $this->renderView('pdf/reclamationpdf.html.twig', [
            'Reclamationn' => [$Reclamationn],
        ]);

        // Instantiate the dompdf class and render the HTML
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Set the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Return the PDF as a response
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="planning.pdf"',
        ]);
    }
    /*#[Route('/generate-pdf-all', name: 'app_generate_pdf_all')]
    public function generatePdfAction()
    {
        $reclamationn = $this->getDoctrine()
            ->getRepository(Reclamationn::class)
            ->findAll();
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();

        // Générer le HTML à partir d'un template Twig
        $html = $this->renderView('pdf/reclamationspdf.html.twig', [
            'reclamationn' => $reclamationn
        ]);

        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendre le PDF
        $dompdf->render();

        // Renvoyer le PDF au navigateur
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'reclamationn/pdf',
            'Content-Disposition' => 'inline; filename="reclamationns.pdf"'
        ]);
    }*/

}

