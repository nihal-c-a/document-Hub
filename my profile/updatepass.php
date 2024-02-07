<?php
if(isset($_POST['reset']))
{
  session_start();
$xpass=$_POST['pass'];
$npass=$_POST['npass'];
$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'docloc';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
	$user = $_SESSION['user'];
    $query = "SELECT pass FROM rdetails WHERE email = '$user'";
	$result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
 
    if($result->num_rows!=0)
    {
        if($xpass==$row['pass'])
        {
            $qry="update rdetails set pass='".$npass."' where email='".$user."'";
            $rslt=$conn->query($qry);
            echo '<script>alert("Password updated successully");</script>';
            echo"<script>window.location.href='../login.php';</script>";
            mysqli_close($conn);
        }
        else{
            echo '<script>alert("enter correct old password");</script>';
        }
    }
    
   
   
    
	// 

}
?>