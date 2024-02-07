<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file is uploaded
    if (isset($_FILES['file'])) {
        // Specify the target directory to store uploaded files
        $targetDirectory = 'uploads/';

        // Get the file name and path
        $fileName = $_FILES['file']['name'];
        $fileTempPath = $_FILES['file']['tmp_name'];

        // Generate a unique name for the uploaded file
        $uniqueFileName = uniqid() . '_' . $fileName;

        // Move the uploaded file to the target directory
        $targetFilePath = $targetDirectory . $uniqueFileName;
        move_uploaded_file($fileTempPath, $targetFilePath);

        // Convert the file to PDF using mPDF or PHPWord
        require_once 'vendor/autoload.php';
        require_once 'vendor/phpoffice/phpword/src/PhpWord/PhpWord.php';
        require_once 'vendor/phpoffice/phpword/src/PhpWord/IOFactory.php';

        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $outputFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.pdf'; // Define the output file name

        switch ($fileType) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                // Convert image to PDF using mPDF
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->SetDisplayMode('fullpage');

                $imagePath = realpath($targetFilePath);
                $imageData = file_get_contents($imagePath);
                $base64Image = base64_encode($imageData);
                $base64ImageSrc = 'data:image/' . $fileType . ';base64,' . $base64Image;

                $mpdf->WriteHTML('<img src="' . $base64ImageSrc . '">');
                $mpdf->Output($outputFileName, 'D');
                break;
            case 'html':
                // Convert HTML to PDF using mPDF
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->SetDisplayMode('fullpage');

                $htmlContent = file_get_contents($targetFilePath);
                $mpdf->WriteHTML($htmlContent);
                $mpdf->Output($outputFileName, 'D');
                break;
            case 'doc':
            case 'docx':
                // Convert DOC and DOCX to PDF using PHPWord
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($targetFilePath);

                // Specify the PDF rendering library and its path
                \PhpOffice\PhpWord\Settings::setPdfRendererPath('vendor/dompdf/dompdf');
                \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                // Create the PDF writer
                $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
                $pdfWriter->save($outputFileName);

                header("Content-Type: application/pdf");
                header("Content-Disposition: attachment; filename=\"$outputFileName\"");
                readfile($outputFileName);
                break;
            default:
                echo 'Unsupported file format.';
                exit;
        }
        unlink($targetFilePath);
        exit;
    }
}
?>
