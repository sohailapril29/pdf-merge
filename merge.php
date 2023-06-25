<?php
require('fpdf/fpdf.php');
require('fpdi/src/autoload.php');

use \setasign\Fpdi\Fpdi;

// Check if files were uploaded
if(isset($_FILES['pdfFiles'])) {
  $pdfFiles = $_FILES['pdfFiles'];

  $outputPdf = 'merged.pdf';

  // Create an instance of Fpdi
  $pdf = new Fpdi();

  // Loop through each uploaded file
  foreach($pdfFiles['tmp_name'] as $key => $tmpName) {
    $pdfFilePath = $pdfFiles['tmp_name'][$key];
    
    // Add the pages of the PDF file to the merged PDF
    $pageCount = $pdf->setSourceFile($pdfFilePath);
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
      $templateId = $pdf->importPage($pageNo);
      $pdf->AddPage();
      $pdf->useTemplate($templateId);
    }
  }

  // Output the merged PDF file
  $pdf->Output('F', $outputPdf);
  
  // Set appropriate headers for file download
  header('Content-Type: application/pdf');
  header('Content-Disposition: attachment; filename="'.$outputPdf.'"');
  
  // Output the merged PDF file
  readfile($outputPdf);
  
  // Delete the temporary merged PDF file
  unlink($outputPdf);
}
?>
