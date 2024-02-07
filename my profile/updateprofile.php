<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'docloc';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start();
$user = $_SESSION['user'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$adr = $_POST['adr'];
$pcode= $_POST['pcode'];

$qry="update rdetails set fname='".$fname."',lname='".$lname."',adr='".$adr."',pcode='".$pcode."' where email='".$user."'";
$rslt=$conn->query($qry);
if($rslt)
{
    echo '<script>alert("profile updated successfully");</script>';
    mysqli_close($conn);
    echo"<script>window.location.href='viewprofile.php';</script>";
    
}
?>