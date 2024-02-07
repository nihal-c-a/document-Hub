<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'docloc';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

$email = $_POST['email'];
$pass = $_POST['pass'];

$query = "SELECT pass FROM rdetails WHERE email='$email' and pass='$pass'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  echo 'exists';
} else {
  echo 'not exists';
}
?>
