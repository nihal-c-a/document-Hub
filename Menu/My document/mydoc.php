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
	<style>
		#cardcontainer {
			width: 95%; 
			display: flex;
			flex-wrap: wrap;
			
			gap: 20px;
		}

		.card {
			
			position: relative;
			width: 200px;
			height: 300px;
			perspective: 1000px;
			cursor: pointer;
			transition: transform 0.3s ease, box-shadow 0.3s ease;
			

}

.card:hover {
  transform: scale(1.1);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}
		.card-inner {
			position: absolute;
			width: 100%;
			height: 100%;
			transform-style: preserve-3d;
			transition: transform 0.5s;
		}

		.card-flipped .card-inner {
			transform: rotateY(180deg);
		}

		.card-front,
		.card-back {
			
			position: absolute;
			width: 100%;
			height: 100%;
			backface-visibility: hidden;
			display: flex;	
			line-height: 0.7;	
  			flex-direction: column;
			/* justify-content: center; */
			
			
			
			color: white;
			border-radius: 10px;
		}

		.card-front {
			font-family: Arial, sans-serif;
			background-color: #23405c;
			font-weight: bold;
			font-size: 24px;
			align-items: center;
		}

		.card-back {
			padding:5px;
			background-color: orange;
			transform: rotateY(180deg);
			font-size: 20px;
			line-height: 1;
			overflow: auto; 
		}
		::-webkit-scrollbar {
      width: 0;
      height: 0;
    }
	</style>
	<script  src="../../register/jquery-3.6.4.js"></script>
	<script>
		function checkName(name) {
  var emailInput = document.getElementById("name");
  var spanElement = document.getElementById("espan");
  $.ajax({
    url: 'namecheck.php',
    type: 'POST',
    data: {name: name},
    success: function(response) {
      if (response == 'exists') { 
		
        emailInput.setCustomValidity("duplicate file names");
        spanElement.innerHTML = "file with this name already exists";
      }else{
        emailInput.setCustomValidity("");
        spanElement.innerHTML = "";
      }
    }
  });
}
		function flipCard(card) {
  // Get the checkbox element inside the card
  var checkbox = card.querySelector('input[type="checkbox"]');
  
  // Check if the checkbox is checked
  if (!checkbox.checked) {
    // Toggle the "card-flipped" class
    card.classList.toggle("card-flipped");
  }
}
    function sendSelectedFiles() {
			var fileForm = document.getElementById("fileForm");
			var selectedFiles = [];
			var checkboxes = fileForm.querySelectorAll("input[name='selectedFiles[]']:checked");

			console.log("Number of checkboxes: " + checkboxes.length);
			if (checkboxes.length > 0) {
				var phoneNumber = prompt("Please enter username(email) you want to share this document with");

				for (var i = 0; i < checkboxes.length; i++) {
					selectedFiles.push(checkboxes[i].value);
					var n = selectedFiles.join(",");
					if (phoneNumber) {
						var url = "sharedoc.php?n=" + n + "&rec=" + encodeURIComponent(phoneNumber);
						window.location.href = url;
					}
				}
			} else {
				alert("No files selected");
			}
		}

		function deleteSelectedFiles() {
			var fileForm = document.getElementById("fileForm");
			var selectedFiles = [];
			var checkboxes = fileForm.querySelectorAll("input[name='selectedFiles[]']:checked");

			if (checkboxes.length > 0) {
				if (confirm("Do you really want to delete the "+checkboxes.length+" files?")) {
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
		function validateFileSize(event) {
  const file = event.target.files[0]; // Get the selected file
  const fileSize = file.size / 1024 / 1024; // Convert file size to MB

  if (fileSize > 50) {
    alert("Maximum file size allowed is 50MB.");
    event.target.value = ""; // Clear the selected file
  }
}

	</script>
</head>
<body>
	<div id="bar">
		<a style="position:absolute;color:#ddd; top:10px;" href="../menu.php">Back</a>
		<h1 style="margin-top:6px;">My Documents</h1>
	</div>

	<div class="container">
		<h2 style='background-color: white;border-radius: 10px;padding: 10px; width:95%;'>Add New Document</h2>
		<form method="post" action="docinsert.php" enctype="multipart/form-data">
			<label style='color:white;background-color: rgba(35, 64, 92,0.9); width:155px;padding:6px;border-radius:5px;'>Document Name:</label>
			<input type="text" maxlength='15' style='margin-bottom:5px; ' name="name" id="name" onchange="checkName(this.value)" required><br>
			<span style='color:red;' class="mySpan" id="espan"></span>
			<label style='color:white;background-color: rgba(35, 64, 92,0.9); width:190px;padding:6px;border-radius:5px;'>Document Description:</label>
			<textarea name="description" style='margin-bottom:5px; ' required></textarea>
			<label style='color:white;background-color: rgba(35, 64, 92,0.9); width:110px;padding:6px;border-radius:5px; '>Choose File:</label>
			<input type="file" name="file" required onchange="validateFileSize(event)">
			<input type="submit" value="upload Document">
		</form>
		<a class='btn' href='../collaborations/sent.php' style='background-color:orange;'>Collaborations</a>
		<h2 style='background-color: white;border-radius: 10px;padding: 10px; width:95%;'>All Documents</h2>
		<form id="fileForm" action="#">
		<div style='display:flex;'>
			<a class='btn' onclick='sendSelectedFiles()' style='margin:20px;margin-left:0px;' title='Share'>
    			<img src='ftype/share.gif' style='border-radius: 55%;' height='50px' width='50px'>
			</a>
			<a class='btn' onclick='downloadSelectedFiles()' style='margin:20px;' title='Download'>
    			<img src='ftype/download.gif' style='border-radius: 55%;' height='50px' width='50px'>
			</a>
			<a class='btn' style='background-color:red; margin:20px;' onclick='deleteSelectedFiles()' title='Delete'>
    			<img src='ftype/delete.gif' style='border-radius: 55%;' height='50px' width='50px'>
			</a>
				<div style="display: flex;margin-left:800px;  align-items: center; width:max-content;">
  					<label for="selectAllCheckbox" >Select-All</label>
  					<input type="checkbox" id="selectAllCheckbox" style="height: 40px; width: 80px; margin: 0; background-color: #00ff00; align-text:left;" onclick="toggleAllCheckboxes()">
				</div>
	</div>
			<div id="cardcontainer">
				<?php
				// Connect to the database
				$dbhost = 'localhost';
				$dbuser = 'root';
				$dbpass = '';
				$dbname = 'docloc';
				$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

				// Get all the documents from the table
				$sql = "SELECT * FROM docfiles where email='" . $user . "'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);

				// Display each document in a card
				if ($row > 0) {
					while ($row) {
						$fileExtension = $row['file'];
						$filename=$row['name'];
						$description=$row['description'];
						$file=$filename.'.'.$fileExtension;

						$filePath = 'C:\xampp\htdocs\Document Hub\Menu\My document\uploads\\'.$user.'\\'.$file; // Replace this with the path to your file
						$fileSize = (filesize($filePath)/1024);
						$ftime = filectime($filePath);
						$ftime =date('d-m-Y H:i', $ftime);
						$filePath='http://localhost/Document Hub/Menu/My document/uploads/'.$user.'/'. $file;
				
						if (strtolower($fileExtension) === 'jpg' || strtolower($fileExtension) === 'jpeg' || strtolower($fileExtension) === 'png' || strtolower($fileExtension) === 'gif' || strtolower($fileExtension) === 'bmp' || strtolower($fileExtension) === 'svg' || strtolower($fileExtension) === 'tiff') {
							$ftype = 'Image';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/image.png';
						} elseif (strtolower($fileExtension) === 'mp4' || strtolower($fileExtension) === 'avi' || strtolower($fileExtension) === 'mov' || strtolower($fileExtension) === 'wmv' || strtolower($fileExtension) === 'flv') {
							$ftype = 'Video';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/video.png';
						} elseif (strtolower($fileExtension) === 'docx' || strtolower($fileExtension) === 'doc') {
							$ftype = 'Word';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/word.png';
						} elseif (strtolower($fileExtension) === 'pptx' || strtolower($fileExtension) === 'ppt') {
							$ftype = 'powerpoint';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/ppt.png';
						} elseif (strtolower($fileExtension) === 'xlsx' || strtolower($fileExtension) === 'xls') {
							$ftype = 'Excel';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/excel.png';
						} elseif (strtolower($fileExtension) === 'pdf') {
							$ftype = 'PDF';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/pdf.png';
						} elseif (strtolower($fileExtension) === 'rar' || strtolower($fileExtension) === 'zip') {
							$ftype = 'Archive';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/zip.png';
						} elseif (strtolower($fileExtension) === 'txt') {
							$ftype = 'Text';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/text.png';
						} elseif (strtolower($fileExtension) === 'mp3' || strtolower($fileExtension) === 'wav' || strtolower($fileExtension) === 'ogg') {
							$ftype = 'Audio';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/audio.png';
						} elseif (strtolower($fileExtension) === 'cpp' || strtolower($fileExtension) === 'java' || strtolower($fileExtension) === 'py' || strtolower($fileExtension) === 'php' || strtolower($fileExtension) === 'js' || strtolower($fileExtension) === 'html') {
							$ftype = 'Script';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/script.png';
						} elseif (strtolower($fileExtension) === 'exe' || strtolower($fileExtension) === 'dll' || strtolower($fileExtension) === 'bat') {
							$ftype = 'Executable file';
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/exe.png';
						} else {
							$ftype = $fileExtension;
							$source = 'http://localhost/Document Hub/Menu/My document/ftype/others.png';
						}
							
				
						echo '
						<div class="card" onclick="flipCard(this)">
							<div class="card-inner">
								<div class="card-front">
								<br><p > ' . $filename . '</p><br>
								<img src="'.$source.'" alt="other image file" width="150" height="150">
								<br><p style="border-top: 1px solid white; border-bottom: 3px solid white; padding:10px;">' . $fileExtension . '</p><br><input type="checkbox" style="height:20px; width:40px;" name="selectedFiles[]" value="' . $row['id'] . '">
								
								</div>
								<div class="card-back">
								<br><p style="background-color: #23405c; color: white; padding: 10px;  margin: 0; font-size: 14px; font-weight: bold; border-radius:5px; text-align:center;" >File-Type: ' . $ftype . '</p><br>';
								if($ftype=='Video')
								{
									echo'<video src="'.$filePath.'" style="margin-left:20px;" width="150" height="150"  loop controls></video>';
									echo'<p style="border: 1px solid white; color: white; padding: 10px;  margin: 5px; font-size: 14px;  border-radius:5px;">' . $description . ' </p>';
								}
								elseif($ftype=='Image'){
									echo'<img src="'.$filePath.'" style="margin-left:20px;" alt="other image file" width="150" height="150">';
									echo'<p style="border: 1px solid white; color: white; padding: 10px;  margin: 5px; font-size: 14px;  border-radius:5px;">' . $description . ' </p>';
								}
								elseif($ftype=='Audio'){
									echo'<audio src="'.$filePath.'" style=";padding-left:0px;" width="70px" height="10px"  loop controls></audio>';
									echo'<p style="border: 1px solid white; color: white; padding: 10px;  margin: 5px; font-size: 14px;  border-radius:5px;">' . $description . ' </p>';
								}
								elseif($ftype=='PDF'){
									echo'<p >file size:' . $fileSize . ' kb</p><br>';
									echo'<p>Time:' . $ftime . ' </p>';
									echo'<p style="border: 1px solid white; color: white; padding: 10px;  margin: 5px; font-size: 14px;  border-radius:5px;">' . $description . ' </p>';
									echo '<a class ="btn" target="_blank" href="' . $filePath . '">View PDF</a>';
								}
								else{
									
									echo'<p >file size:' . $fileSize . ' kb</p><br>';
									
									echo'<p>Time:' . $ftime . ' </p>';
									echo'<p style="border: 1px solid white; color: white; padding: 10px;  margin: 5px; font-size: 14px;  border-radius:5px;">' . $description . ' </p>';
									echo '<a class ="btn" style="align-text:center; " href="' . $filePath . '">Download</a>';
								}
								echo'</div>
							</div>
						</div>';
				
						$row = mysqli_fetch_assoc($result);
					}
				} else {
					
					echo "<h1 style='background-color: red;border-radius: 10px;padding: 10px;'>No files found</h1>";
				}
				
				?>
			</div>
			
      </div>
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
		// Add active class to the selected tab
		const list = document.querySelectorAll('.list');

		function activeLink() {
			list.forEach((item) => item.classList.remove('active'));
			this.classList.add('active');
		}

		list.forEach((item) => item.addEventListener('click', activeLink));
	</script>
</body>

</html>
