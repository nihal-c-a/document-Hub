<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'docloc';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (isset($_POST['email'])) {
  // check if email exists in database
  $email = $_POST['email'];
  $query = "SELECT * FROM rdetails WHERE email='$email'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    echo 'exists';
  } else {
    echo 'not exists';
  }
} elseif (isset($_POST['pno'])) {
  // check if phone number exists in database
  $phone = $_POST['pno'];
  $query = "SELECT * FROM rdetails WHERE pno='$phone'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    echo 'exists';
  } else {
    echo 'not exists';
  }
}
?>
