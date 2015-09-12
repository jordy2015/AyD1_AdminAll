	<?php  
	if($_POST['usu']=="Admin" && $_POST['pass']=="123456789"){
		session_start();
		$_SESSION['ingreso']="bien";
		header("Location: http://localhost/index.php");
	}else{
		header("Location: http://localhost/signin.php?session=false");
	}
	?>