<?php
session_start();
$sender = $_SESSION['user'];
$allid=$_GET['n'];
$filearray = preg_split("/,/", $allid);
$length = count($filearray);
if($length==1){
$reciever=$_GET['rec'];
$id = $filearray[0];
$time=date("l, F j, Y, g:i a");
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'docloc';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$query = "create table if not exists docshare(
	id INT,
	toemail VARCHAR(255) NOT NULL,
	fromemail VARCHAR(255) NOT NULL,
	stime VARCHAR(255),
	FOREIGN KEY (id) REFERENCES docfiles(id) ON DELETE CASCADE	
  )";
$result = mysqli_query($conn, $query);

$sql2 = "select * from docshare where id='$id' and  toemail='$reciever' and fromemail='$sender'";
$result2=mysqli_query($conn, $sql2);
$row2=mysqli_fetch_assoc($result2);
if($row2){
	echo '<script>alert("File already shared");</script>';
	echo"<script>window.location.href='mydoc.php';</script>";
	mysqli_close($conn);
	exit();
}

$sql = "select * from rdetails where email='$reciever'";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);
if(($row>0||$reciever=='PUBLIC') && $reciever!=$sender){
$sql = "INSERT INTO docshare(id,stime,fromemail,toemail) VALUES ('$id', '$time','$sender', '$reciever')";
mysqli_query($conn, $sql);
echo '<script>alert("File shared successfully");</script>';
mysqli_close($conn);
echo"<script>window.location.href='../collaborations/sent.php';</script>";
}
else{
    echo '<script>alert("invalid recepient");</script>'; 
}
echo"<script>window.location.href='mydoc.php';</script>";
mysqli_close($conn);
}
else{
	$allid=$_GET['n'];
	 
	$filearray = preg_split("/,/", $allid);
	$reciever=$_GET['rec'];
	// $id = $_GET['id'];
	$time=date("l, F j, Y, g:i a");
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'docloc';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	$query = "create table if not exists docshare(
		id INT,
		toemail VARCHAR(255) NOT NULL,
		fromemail VARCHAR(255) NOT NULL,
		stime VARCHAR(255),
		FOREIGN KEY (id) REFERENCES docfiles(id) ON DELETE CASCADE	
	  )";
	$result = mysqli_query($conn, $query);
	foreach ($filearray as $id) {
	$sql2 = "select * from docshare where id='$id' and  toemail='$reciever' and fromemail='$sender'";
	$result2=mysqli_query($conn, $sql2);
	$row2=mysqli_fetch_assoc($result2);
	if($row2){
		continue;
	}
	
	$sql = "select * from rdetails where email='$reciever'";
	$result=mysqli_query($conn, $sql);
	$row=mysqli_fetch_assoc($result);
	if(($row>0||$reciever=='PUBLIC') && $reciever!=$sender){
	$sql = "INSERT INTO docshare(id,stime,fromemail,toemail) VALUES ('$id', '$time','$sender', '$reciever')";
	mysqli_query($conn, $sql);
	
	
	}
	else{
		echo '<script>alert("invalid recepient");</script>'; 
		echo"<script>window.location.href='mydoc.php';</script>";
	mysqli_close($conn);
	exit();
	}
}
echo '<script>alert("File shared successfully");</script>';
	mysqli_close($conn);
	echo"<script>window.location.href='../collaborations/sent.php';</script>";
}
?>