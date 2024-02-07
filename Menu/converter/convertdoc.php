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

        // Convert the file to PDF using Pandoc
        $outputFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.pdf'; // Define the output file name

        // Execute the Pandoc command
        $command = 'pandoc -s ' . $targetFilePath . ' -o ' . $outputFileName;
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0) {
            // PDF conversion successful
            header("Content-Type: application/pdf");
            header("Content-Disposition: attachment; filename=\"$outputFileName\"");
            readfile($outputFileName);
        } else {
            // PDF conversion failed
            echo 'PDF conversion failed.';
            echo 'Error Output: ' . implode("\n", $output);
        }
        

        // Clean up the temporary files
        unlink($targetFilePath);
        unlink($outputFileName);

        exit;
    }
}
?>
