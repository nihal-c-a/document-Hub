<!DOCTYPE html>
<html>
<head>
	<title>Document Management System - View Document</title>
	<link rel="stylesheet" type="text/css" href="mydoc.css">
</head>
<body>
<?php
		// Include database configuration file
		$dbhost = 'localhost';
				$dbuser = 'root';
				$dbpass = '';
				$dbname = 'docloc';
				$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

		// Get the document ID from the URL parameter
		$id = $_GET['id'];

		// Get the document details from the database
		session_start();
				$user = $_SESSION['user'];
		$query = "SELECT * FROM docfiles WHERE id = '$id' and email = '$user'";
		$result = mysqli_query($conn, $query);
  ?>
<div id=bar>
<a style="position:absolute;color:#ddd; top:10px;" href="mydoc.php">Back</a>
<?php
$row = mysqli_fetch_assoc($result);
			echo "<h1 style='margin-top:6px;'>" . $row['name'] . "</h1>";
      ?>
		</div>
 
	<div class="container">
	<div class="container">
		
		
		

		

		
			<?php
			echo "<p>" . $row['description'] . "</p>";
            echo'<object data="'.$row['file'].'" type="application/docx" width="100%" height="600px">';
			


		// Close database connection
		mysqli_close($conn);
		?>
	</div>
	<div class="navigation">
        <ul>
          <li class="list active">
            <a href="../menu.php">
              <span class="icon"><image src="../home.png" height="40px" width="40px"></span>
              <span class="title">&nbsp&nbspHome</span>
            </a>
          </li>
          <li class="list">
            <a href="#">
              <span class="icon"><image src="../myProfile.png" height="40px" width="40px"></span>
              <span class="title">&nbsp&nbspprofile</span>
            </a>
          </li>
          <li class="list">
            <a href="logout.php">
              <span class="icon"><image src="../logout.png" height="40px" width="40px"></span>
              <span class="title">&nbsp&nbsplogout</span>
            </a>
          </li>
        </ul>
      </div>
  <script>
        //add active class in selected tab
        const list =document.querySelectorAll('.list');
        function activeLink(){
          list.forEach((item)=>
          item.classList.remove('active'));
          this.classList.add('active');

        }
        list.forEach((item)=>
        item.addEventListener('click',activeLink))
      </script>
</body>
</html>
