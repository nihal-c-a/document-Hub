<?php
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$email=$_POST['email'];
$pass=$_POST['pass'];
$pno=$_POST['pno'];
$adr=$_POST['adr'];
$pcode=$_POST['pcode'];

@$cn=new mysqli('localhost','root','','docloc');
if(mysqli_connect_errno())
{
    echo "could not connect";
}
else
{
    $qry="insert into rdetails values('".$fname."','".$lname."','".$email."','".$pass."','".$pno."','".$adr."','".$pcode."')";
    $rslt=$cn->query($qry);
    echo '<script> window.alert("account sign up successfull.");</script>';
    // echo "<script>setTimeout(function(){ alert('account sign up successfull'); }, 10);</script>";
    echo"<script>window.location.href='../login.php';</script>";
}

?>