<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'docloc';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start();
$user = $_SESSION['user'];
$name = $_POST['name'];


$query = "SELECT name FROM docfiles WHERE name='".$name."' AND email='".$user."'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  echo 'exists';
} else {
  echo 'not exists';
}

?>