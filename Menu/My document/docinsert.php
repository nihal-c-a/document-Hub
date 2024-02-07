<?php
	//connect to the database
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'docloc';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	session_start();
	$user = $_SESSION['user'];
	
	//get the form data
	$name = $_POST['name'];
	$description = $_POST['description'];
	if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
		$file_content = file_get_contents($_FILES["file"]["tmp_name"]);
		
		// Save the file to the server
		$filename = $_FILES["file"]["name"];
		$filearray = explode(".", $filename);
		$ftype=end($filearray);
		if (!file_exists("uploads/".$user."/")) {
		if (mkdir("uploads/".$user."/", 0777, true)) {
		}
	}
		$filepath = "uploads/".$user."/". $name.'.'.$ftype;
		file_put_contents($filepath, $file_content);
		
		
		$sql = "INSERT INTO docfiles(email,name, description, file) VALUES ('$user','$name', '$description', '$ftype')";
		mysqli_query($conn, $sql);
		echo '<script>alert("File uploaded successfully");</script>';
		echo"<script>window.location.href='mydoc.php';</script>";
		
	}
	   else {
		echo '<script>alert("Error uploading file");</script>';
		echo"<script>window.location.href='mydoc.php';</script>";
		
		
	  }
	  mysqli_close($conn);
?>