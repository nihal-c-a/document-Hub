<?php
//connect to the database
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'docloc';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start();
$user = $_SESSION['user'];
if(isset($_GET["all"])){
    $query = "delete FROM docshare where fromemail= '$user'";
    $result=mysqli_query($conn, $query);
    echo '<script>alert("All file access removed succesfully");</script>';
    mysqli_close($conn);  
    echo"<script>window.location.href='sent.php';</script>";
    exit();
}
$id=$_GET["id"];
$rec=$_GET["rec"];
$query = "SELECT name,file FROM docfiles WHERE  id = '$id'and  email= '$user'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$query = "delete FROM docshare WHERE id = '$id' and  fromemail= '$user' and  toemail= '$rec'";
mysqli_query($conn, $query);
echo '<script>alert("file access removed succesfully");</script>';
mysqli_close($conn);
echo"<script>window.location.href='sent.php';</script>";

}
?>
