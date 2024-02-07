<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'docloc';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Get the document ID from the URL parameter
if(isset($_GET['n'])){
$id = $_GET['n'];
session_start();
$user = $_SESSION['user'];
}
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $user=$_GET['email'];
}
// Get the document details from the database
$query = "SELECT name,file FROM docfiles WHERE id = '$id'and email = '$user'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$dfile=$row['name'].'.'.$row['file'];
$filename = $dfile;
$file =$dfile;
// Set the file path
$file = 'C:/xampp/htdocs/document hub/Menu/My document/uploads/'.$user.'/'. $file;

// Set the filename that the user will see


// Set the HTTP headers to force the browser to download the file
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($file));

// Read the file and output it to the browser
readfile($file);
mysqli_close($conn);
}