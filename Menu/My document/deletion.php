<?php
// Connect to the database
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'docloc';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start();
$allid = $_GET['n'];
$filearray = explode(",", $allid);
$user = $_SESSION['user'];
$file='';
$flag=0;
foreach($filearray as $id){
    $id = intval($id);
    $query = "SELECT name, file FROM docfiles WHERE id = " . $id . " AND email = '" . $user. "'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $file = $row['name'].'.'.$row['file'];
        // Set the file path
        $file = 'C:/xampp/htdocs/Document Hub/Menu/My document/uploads/'.$user.'/'. $file;

        // Delete the file
            // Delete the record from the database
            $deleteQuery = "DELETE FROM docfiles WHERE id = " . $id . " AND email = '" .  $user. "'";
            mysqli_query($conn, $deleteQuery);
            if (unlink($file)) {
                $flag=1;
                }
            
    }
}
if ($flag==1) {
echo '<script>alert("Deleted successfully");</script>';
}
mysqli_close($conn);
echo"<script>window.location.href='mydoc.php';</script>";
?>
