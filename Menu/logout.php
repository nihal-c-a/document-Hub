<?php
session_start();

unset($_SESSION['user']);
session_destroy();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");

header('Location: ../login.php');
exit();
?>
