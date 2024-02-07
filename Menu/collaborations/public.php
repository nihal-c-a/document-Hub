<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="../../logo.png" type="image/x-icon">
	
	<title>Collab-Public</title>

	<link rel="stylesheet" type="text/css" href="../My document/mydoc.css">
</head>
<body>
<div id=bar>
<a style="position:absolute;color:#ddd; top:10px;" href="../menu.php">Back</a>
		<h1 style="margin-top:6px;">Public Collab</h1>
		</div>
 
	<div class="container">
	
		<h2> </h2>
        <a class='btn' href='sent.php' style='background-color:green;'>View Sent files</a> <a class='btn' href='../My document/mydoc.php' style='background-color:black;'>My documents</a>  <a class='btn' href='received.php' style='background-color:blue;'>Back to private</a>
		<br><br><table>
			<tr>
				<th>File Name</th>
				<th>Time</th>
				<th>Description</th>
				<th>Received From</th>
				<th>Download</th>
				
			</tr>
			<?php
				//connect to the database
				$dbhost = 'localhost';
				$dbuser = 'root';
				$dbpass = '';
				$dbname = 'docloc';
				$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
				session_start();
				$user = $_SESSION['user'];
				//get all the documents from the table
				$sql = "SELECT id,stime,fromemail FROM docshare where toemail='PUBLIC'";
				$result = mysqli_query($conn, $sql);
				$row=mysqli_fetch_assoc($result);
				//display each document in a table row
				if($row>0){
				while($row) {
                    $sql1 = "SELECT name,description FROM docfiles where id='".$row['id']."' and email='".$row['fromemail']."'";
				$result1 = mysqli_query($conn, $sql1);
				$row1=mysqli_fetch_assoc($result1);
					echo "<tr>";
					echo "<td>" . $row1['name'] . "</td>";
					echo "<td>" . $row['stime'] . "</td>";
					echo "<td>" . $row1['description'] . "</td>";
					echo "<td>" . $row['fromemail'] . "</td>";
					echo "<td><a class='btn' href='../My document/download.php?id=" . $row['id'] . "&email=" . $row['fromemail'] . "'><image src='download.png' height=20px width=20px></a></td>";
					
					echo "</tr>";
					$row=mysqli_fetch_assoc($result);
				}
			}else{
				echo "<tr>";
					echo "<td colspan='6' style='color: red; font-size:20px; font-family:calibri; background-color:rgba(255, 255, 255,.5);'> No user shared file publicly! Public files will appear here</td>";
					echo "</tr>";
			}

				//close the database connection
				mysqli_close($conn);
			?>
		</table>
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
            <a href="../../my profile/viewprofile.php">
              <span class="icon"><image src="../myprofile.png" height="40px" width="40px"></span>
              <span class="title">&nbsp&nbspprofile</span>
            </a>
          </li>
          <li class="list">
            <a href="../logout.php">
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
