
<!DOCTYPE html>
<html>
<head>
  <title>Menu</title>
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <link rel="icon" href="../logo.png" type="image/x-icon">
  <link rel="stylesheet"  type="text/css" href="slidebar.css">
  <style>
    body {
      font-family: sans-serif;
    background-image:url("../h8.jpg");
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover; 
    }
    /* #im{
      position: absolute;
      top: 220px;
      left: 120px;
    } */
    .circular-menu{
      position: fixed;
      bottom: 200px;
      right: 650px;
      display: flex;
      flex-direction: radius;
      justify-content: center;
      align-items: center;
      width: 250px;
      height: 300px;
      border-radius: 50%;
      background-image: url("menu.png");
      background-size:60%;
      background-repeat: no-repeat;
      background-position: center;
      box-shadow: 0px 0px 100px black;
      z-index: 9999;
      transition: all 0.3s;
    }
    .circular-menu:hover {
      transform: scale(1.2);
      background-color: rgb(6, 61, 95);
      cursor: pointer;
      background-image: url("net.gif");
      background-size:100%;
      background-repeat: no-repeat;
      background-position: center;
      box-shadow: 0px 0px 50px #fff, 0px 0px 100px #fff, 0px 0px 150px #fff;
    }
    .circular-menu-item {
      position: absolute;
      width: 170px;
      height: 150px;
      border-radius: 70%;
      background-color: white;
      box-shadow: 0px 0px 5px #888888;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: all 0.3s;
      transform: scale(0);
    }
    .circular-menu-item:hover {
      background-color: #0d0a0c;
      color: white;
      transform: scale(1.2);
      cursor: pointer;
      box-shadow: 0px 0px 20px #110f11, 0px 0px 40px #151315, 0px 0px 60px #862878;
    }
    .circular-menu:hover .circular-menu-item {
      transform: scale(1);
    }
    .circular-menu-item:nth-child(1){
      top: -110px;
      right: 50;
      background-image:url("ico2/mydocuments.png");
      background-repeat: no-repeat;
    /* background-attachment: fixed; */
    background-color:#233b5c ;
    background-position: center;
    background-size:80%;
    }
    .circular-menu-item:nth-child(2) {
      right: 0;
      left: 200px;
      background-image:url("ico2/convertfile.png");
      background-repeat: no-repeat;
    /* background-attachment: fixed; */
    background-color: #233b5c;
    background-position: center;
    background-size:80%;
    }
    .circular-menu-item:nth-child(3) {
      right: 0;
      right: 200px;
      background-image:url("ico2/createown.png");
      background-repeat: no-repeat;
    /* background-attachment: fixed; */
    background-color: #23405c;
    background-position: center;
    background-size:80%;
      
    }
    .circular-menu-item:nth-child(4) {
      bottom: -100px;
      right: 50;
      background-image:url("ico2/collaborations.png");
      background-repeat: no-repeat;
    /* background-attachment: fixed; */
    background-color: #233b5c;
    background-position: center;
    background-size:80%;
    }
    
    .circular-menu-item i {
      font-size: 20px;
    }
    .navbar{
      position:absolute;
      display:flex;
      border :1px solid black;
      width:100% ;
      background: red;

    }
    #bar{
      font-family: sans-serif;
      position:absolute;
      top:0%;
      width:100%;
      height:6%;
      background-color: #23405c;
    }

   
  </style>
</head>
<body>

    <div id="bar">
    <?php
session_start();
$user = $_SESSION['user'];
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'docloc';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$query = "SELECT fname FROM rdetails WHERE email = '$user'";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$query = "create table if not exists docfiles(
	id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(55),
	name VARCHAR(50) NOT NULL,
	description TEXT,
	file VARCHAR(255),
  FOREIGN KEY (email) REFERENCES rdetails(email)ON DELETE CASCADE
  )";
$result = mysqli_query($conn, $query);

echo "<h3 style='font-size:30px;  color:white; font-family: calibri; margin-top:0px;'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspHi ".$row['fname']."</h3>";
mysqli_close($conn);
?>
  </div>

  
  <div class="circular-menu">
    
   
    <a href="My document/mydoc.php" class="circular-menu-item"><i class="fa fa-home"></i></a>
    <a href="converter/convert.html" class="circular-menu-item"><i class="fa fa-search"></i></a>
    <a href="create own/create.html" class="circular-menu-item"><i class="fa fa-envelope"></i></a>
    <a href="collaborations/sent.php" class="circular-menu-item"><i class="fa fa-user"></i></a>
    
  </div>
  <div class="navigation">
        <ul>
          <li class="list active">
            <a href="">
              <span class="icon"><image src="home.png" height="40px" width="40px"></span>
              <span class="title">&nbsp&nbspHome</span>
            </a>
          </li>
          <li class="list">
            <a href="../my profile/viewprofile.php">
              <span class="icon"><image src="myprofile.png" height="40px" width="40px"></span>
              <span class="title">&nbsp&nbspprofile</span>
            </a>
          </li>
          <li class="list">
            <a href="logout.php">
              <span class="icon"><image src="logout.png" height="40px" width="40px"></span>
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