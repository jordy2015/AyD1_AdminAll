<?php
session_start();
if($_SESSION['ingreso']=="bien"){
unset($_SESSION['ingreso']);
header("Location: http://localhost/signin.php");
}else{
header("Location: http://localhost/signin.php");
}

  ?>