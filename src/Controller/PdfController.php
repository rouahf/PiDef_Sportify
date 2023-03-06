<?php


namespace App\Controller;

use App\Repository\CoursRepository;
use App\Entity\Reclamationn;
use App\Form\ReclamationnType;
use App\Repository\ReclamationnRepository;
use App\Entity\Cours;
use App\Entity\Planning;
use App\Form\PlanningType;
use App\Repository\PlanningRepository;
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
use Dompdf\Options;



class PdfController extends AbstractController
{
    #[Route('/cours-pdf/{id}', name: 'app_generate_pdf')]
    public function generatePdCourss(Request $request, Planning $planning)
    {
        // Generate the PDF content
        $html = $this->renderView('pdf/pdf.html.twig', [
            'plannings' => [$planning],
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
    #[Route('/generate-pdf-all', name: 'app_generate_pdf_all')]
    public function generatePdfAction(PlanningRepository $planningRepository)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        // Créer une instance de Dompdf
        $dompdf = new Dompdf($pdfOptions);

        // Générer le HTML à partir d'un template Twig
        $html = $this->renderView('pdf/pdf.html.twig', [
            'plannings' => $planningRepository->findByWeek(),
        ]);

        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendre le PDF
        $dompdf->render();

        // Renvoyer le PDF au navigateur
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="planning.pdf"',
        ]);
    }
    #[Route('/generate-pdf/{id}', name: 'app_generate_pdf')]
    public function generatePdf(Request $request, Reclamationn $Reclamationn)
    {
        // Generate the PDF content
        $html = $this->renderView('pdf/pdfR.html.twig', [
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

}