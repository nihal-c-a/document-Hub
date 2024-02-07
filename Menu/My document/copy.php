<?php
session_start();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="../../logo.png" type="image/x-icon">
	
	<title>My Documents</title>

	<link rel="stylesheet" type="text/css" href="mydoc.css">
	<script>
		function sendSelectedFiles() {
  var fileForm = document.getElementById("fileForm");
  var selectedFiles = [];
  var checkboxes = fileForm.querySelectorAll("input[name='selectedFiles[]']:checked");
  
  console.log("Number of checkboxes: " + checkboxes.length);
  if(checkboxes.length>0){
	var phoneNumber = prompt("Please enter username(email) you want to share this document with");
  			
  for (var i = 0; i < checkboxes.length; i++) {
    selectedFiles.push(checkboxes[i].value);
	var n=selectedFiles.join(",");
	if (phoneNumber) {
   				var url = "sharedoc.php?n=" + n + "&rec=" + encodeURIComponent(phoneNumber);
    			window.location.href = url;
 			}
  }
}
else{
	alert("no files selected");
}
}
function deleteSelectedFiles() {
  var fileForm = document.getElementById("fileForm");
  var selectedFiles = [];
  var checkboxes = fileForm.querySelectorAll("input[name='selectedFiles[]']:checked");
  
  if (checkboxes.length > 0) {
    if (confirm("Do you really want to delete the selected files?")) {
      for (var i = 0; i < checkboxes.length; i++) {
        selectedFiles.push(checkboxes[i].value);
      }
      
      var n = selectedFiles.join(",");
      var url = "deletion.php?n=" + n;
      window.location.href = url;
    }
  } else {
    alert("No files selected");
  }
}

function downloadSelectedFiles() {
  var fileForm = document.getElementById("fileForm");
  var selectedFiles = [];
  var checkboxes = fileForm.querySelectorAll("input[name='selectedFiles[]']:checked");

  if (checkboxes.length > 0) {
    for (var i = 0; i < checkboxes.length; i++) {
      selectedFiles.push(checkboxes[i].value);
    }

    var index = 0;
    var iframe = document.createElement("iframe");
    iframe.style.display = "none";

    function downloadNextFile() {
      if (index < selectedFiles.length) {
        var fileId = selectedFiles[index];
        var url = "download.php?n=" + fileId;
        iframe.src = url;
        document.body.appendChild(iframe);
        index++;
        setTimeout(downloadNextFile, 1000); // Delay between file downloads (1 second)
      } else {
        alert("selected files downloaded");
        document.body.removeChild(iframe);
      }
    }

    downloadNextFile();
  } else {
    alert("No files selected");
  }
}



function toggleAllCheckboxes() {
		var checkboxes = document.getElementsByName("selectedFiles[]");
		var selectAllCheckbox = document.getElementById("selectAllCheckbox");
		for (var i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = selectAllCheckbox.checked;
		}
	}

	</script>
</head>
<body>
<div id=bar>
<a style="position:absolute;color:#ddd; top:10px;" href="../menu.php">Back</a>
		<h1 style="margin-top:6px;">My Documents</h1>
		</div>
 
	<div class="container">
	<h2>Add New Document</h2>
		<form method="post" action="docinsert.php" enctype="multipart/form-data">
			<label style='color:#4187f6;'>Document Name:</label>
			<input type="text" name="name" required>
			<label style='color:#4187f6;'>Document Description:</label>
			<textarea name="description" required></textarea>
			<label style='color:#4187f6;'>Document File:</label>
			<input type="file" name="file" required>
			<input type="submit" value="Add Document">
		</form>
    <a class='btn' href='../collaborations/sent.php' style='background-color:orange;'>Collaborations</a>
		<h2>All Documents</h2>
		<form id="fileForm" action="#">
	<table style='margin-bottom:10px;'>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>View</th>
			<th>Select all<input type="checkbox" id="selectAllCheckbox" style='height:10px;'onclick="toggleAllCheckboxes()"></th>
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
		$sql = "SELECT * FROM docfiles where email='" . $user . "'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		//display each document in a table row
		if ($row > 0) {
			while ($row) {
				echo "<tr>";
				echo "<td>" . $row['name'] . "</td>";
				echo "<td>" . $row['description'] . "</td>";
				echo "<td><a class='btn' href='download.php?id=" . $row['id'] . "'><image src='open.png' height=20px width=20px></a></td>";
				echo "<td><input type='checkbox' name='selectedFiles[]' value='" . $row['id'] . "'></td>";
				echo "</tr>";
				$row = mysqli_fetch_assoc($result);
			}
	
		} else {
			echo "<tr>";
			echo "<td colspan='7' style='color: red; font-size:20px; font-family:calibri; background-color:rgba(255, 255, 255,.5);'>No Files Found! Please upload👇 to list them here</td>";
			echo "</tr>";
		}
		?>
	</table>
	<a class='btn' onclick='sendSelectedFiles()' ></button><image src='share.png' height=20px width=20px></a>
	<a class='btn' onclick='downloadSelectedFiles()' ></button><image src='download.png' height=20px width=20px></a>
	<a class='btn' style='background-color:red;' onclick='deleteSelectedFiles()' ></button><image src='delete.png' height=20px width=20px></a>
</form>

		
		
		
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
