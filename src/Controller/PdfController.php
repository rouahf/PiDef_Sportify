<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfController extends AbstractController
{
    #[Route('/generate-pdf/{id}', name: 'app_generate_pdf')]
    public function generatePdf(Request $request, Product $product)
    {
        
        // Generate the PDF content
        $html = $this->renderView('pdf/pdf.html.twig', [
            'product' => [$product],
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
            'Content-Disposition' => 'inline; filename="product.pdf"',
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
