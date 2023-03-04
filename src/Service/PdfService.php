<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $domPdf;

    public function __construct() {
        $this->domPdf = new DomPdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream("details.pdf", [
            'Attachement' => true
        ]);
    }

    public function generateBinaryPDF($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->output();
    }
    public function get_min_max_width(): array {
    
        $
    $minWidth = PHP_INT_MAX;
        
        $
    
       
    $maxWidth = 0;
    
        
    
       
    
    
    // Loop through each cell in the row and calculate the minimum and maximum width
        
       
    foreach ($this->cells as $cell) {
            
           
    $cellWidth = $cell->get_width();
            
           
    if ($cellWidth < $minWidth) {
    
               
    $minWidth = $cellWidth;
            }
            
if ($cellWidth > $maxWidth) {
                
               
    $maxWidth = $cellWidth;
                      }

    

    
             }
    
           
    return array("min_width" => $minWidth, "max_width" => $maxWidth);
    }
    
    }
