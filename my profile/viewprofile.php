<!DOCTYPE html>
  <head>
  <link rel="icon" href="../logo.png" type="image/x-icon">
    <script>
      function validatepin() {
        var spanElement = document.getElementById("pinspan");
  var pincode = document.getElementById("pcode");
  var str=new String(pincode.value)
  if (str.length!=6) {
    pincode.setCustomValidity("Enter the valid area pincode");
    spanElement.innerHTML = "Enter the valid area pincode";
  } else {
    pincode.setCustomValidity("");
    spanElement.innerHTML = "";
  }
  
}
      </script>
  <?php
		// Include database configuration file
		$dbhost = 'localhost';
				$dbuser = 'root';
				$dbpass = '';
				$dbname = 'docloc';
				$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

		// Get the document ID from the URL parameter

		// Get the document details from the database
		session_start();
				$user = $_SESSION['user'];
$query = "SELECT fname,lname,email,pno,adr,pcode FROM rdetails WHERE email = '$user'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
  ?>
    <title>My profile</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="icon" href="../../logo.png" type="image/x-icon">
      </script>
  </head>
  <body>
  <?php
  echo '
<form action="updateprofile.php" method="POST">
  <div id="block">
  <div id="form1">
 
    <p id="heading">My Profile</p>
    <img src="../logo.png" style="text-align:center" alt="Description of image" width="100" height="100" id="ico" >
    <div class="input-container">
      <input type="text" name="fname" id="fname" placeholder=" " pattern="[A-Za-z[ ]+" value="'.$row['fname'].'" required >
      <label for="fname">First Name</label>
    </div>

    <div class="input-container">
      <input type="text" name="lname" id="lname" pattern="[A-Za-z]+" placeholder=" "value="'.$row['lname'].'" required >
      <label for="lname">Last Name</label>

    </div>

    <div class="input-container">
      <input type="email" name="email" id="email" placeholder=" " value="'.$row['email'].'" required disabled>
      <label for="email">e-mail</label>
      <span class="mySpan" id="espan"></span>
    </div>

    <div class="input-container">
      <input type="number" name="pno" id="pno" value="'.$row['pno'].'" required disabled >
      <label for="PhoneNumber">Phone number</label>
      <span class="mySpan" id="pnospan"></span>
    </div>

    <div class="input-container">
      <input type="text" name="adr" id="adr" placeholder=" "  value="'. $row['adr'].'" required>
      <label for="adr">Address</label>
    </div>

    <div class="input-container">
      <input type="number" name="pcode" id="pcode" min="111111" placeholder=" " required  value="'.$row['pcode'].'" oninput="validatepin()">
      <label for="pcode">pin code</label>
      <span class="mySpan" id="pinspan"></span>
    </div>
    <input type="submit" value="update" id="sign" name="sign">
    <a class="btn" href="changepass.html">change password</a>
  </div>
 
  
</div>
  </form>

';
mysqli_close($conn);
?>
    <div class="navigation">
        <ul>
          <li class="list active" style="background:none">
            <a href="../Menu/menu.php">
              <span class="icon"><image src="../Menu/home.png" height="40px" width="40px"></span>
              <span class="title">&nbsp&nbspHome</span>
            </a>
          </li>
          <li class="list">
            <a href="../my profile/viewprofile.php" style="background: #007bff; border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
              <span class="icon"><image src="../Menu/myprofile.png" height="40px" width="40px"></span>
              <span class="title">&nbsp&nbspprofile</span>
            </a>
          </li>
          <li class="list">
            <a href="../Menu/logout.php">
              <span class="icon"><image src="../Menu/logout.png" height="40px" width="40px"></span>
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
