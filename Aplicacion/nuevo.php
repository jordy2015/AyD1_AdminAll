<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>Nuevos</title>

	<link rel="shortcut icon" href="assets/images/gt_favicon.png">
	
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="assets/css/main.css">

  <script src="assets/js/swal/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="assets/js/swal/sweetalert.css">

</head>

<body>
		<?php
			session_start();
		if($_SESSION['ingreso']!="bien"){
				header("Location: http://localhost/signin.php");
		}
		?>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="index.php"><img src="assets/images/logo.png" alt="Progressus HTML5 template"  width="200" height="60"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a href="index.php">Menú</a></li>
					<li><a href="nuevo.php">Refrescar</a></li>
					<li class="active"><a class="btn" href="salir.php">Cerrar sesion</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->

	<header id="head" class="secondary"></header>

	<!-- container -->
	<div class="container">

		<ol class="breadcrumb">
			<li><a href="index.php">Menú</a></li>
			<li class="active">Registro</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="page-title">Registro</h1>
				</header>
				
				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="thin text-center">Nuevo Empleado</h3>
							<p class="text-center text-muted">El registro de un nuevo empleado puede deberce a un traslado del empleado o una contratacion del mismo </p>
							<hr>

							<form method="post" action="nuevo.php"  enctype="multipart/form-data">
								<div class="top-margin">
									<label>Codigo <span class="text-danger">*</label>
									<input name="codigo" type="text" class="form-control"  pattern="^\d*[0-9]" required/>
								</div>

								<div class="top-margin">
									<label>Nombre completo<span class="text-danger">*</label>
									<input name="nombre" type="text" class="form-control" required/>
								</div>
								<div class="top-margin">
									<label>Direccion <span class="text-danger">*</span></label>
									<input name="direccion" type="text" class="form-control" required/>
								</div>

								<div class="top-margin">
									<label>Tipo Empleado <span class="text-danger">*</span></label><br>
								
								<select name="tipo" required/>
								<?php
									$servername = "localhost";
									$username = "root";
									$password = "123456789";
									$dbname = "pract1";
									// Create connection
									$conn = new mysqli($servername, $username, $password, $dbname);
									// Check connection
									if ($conn->connect_error) {
									    die("Connection failed: " . $conn->connect_error);
									} 
									$sql = "select puesto, nombre from Puesto";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
										echo "<option> </option>";
									     // output data of each row
									     while($row = $result->fetch_assoc()) {
									        echo "<option>". $row["puesto"]. "-". $row["nombre"]."</option>";
									     }
									} else {
									    echo "0 results";
									}
									$conn->close();
								?>  
								</select>
								</div>

								<div class="top-margin">
									<label>Foto <span class="text-danger">*</span></label>
									<input type="file" name="fileToUpload" required/>
								</div>

								<hr>
								<div class="row">
									<div class="col-lg-8">

									</div>
									<div class="col-lg-4 text-right">
										<button name="registro" class="btn btn-action" type="submit">Registrar</button>
									</div>
								</div>
							</form>
											<?php
											if (isset($_POST['registro'])) 
											{
												$codigo=$_POST['codigo'];
												$nombre=$_POST['nombre'];
												$direccion=$_POST['direccion'];
												$tipo=explode("-", $_POST['tipo']);

												$target_dir = "fotos/";
												$target_file = $target_dir . $codigo . "." .end(explode(".", $_FILES["fileToUpload"]["name"]));
											    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
											    if($check !== false) {
											    	/*if (file_exists($target_file)) {
													        echo "<script type='text/javascript'>
													        sweetAlert(\"Usuario no guardado\", \"Codigo del empleado ya existe\", \"error\");
													        </script>";														    
													*///}else{

															$conexion= mysql_connect("localhost","root","123456789") or die("No se conecto". mysql_error());
															mysql_select_db("pract1");
															mysql_query("start transaction;");
															$query = mysql_query("select NuevoEmpleado(".$codigo.",'".$nombre."','".$direccion."','".$target_file."',".$tipo[0].");");   															
															$result = mysql_result($query,0);
															$spli=explode("-",$result);    													  	
															if($spli[0]==1){
																if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) 
																{ 
																	chmod($target_file, 0777);
 																	mysql_query("commit;");
															        echo "<script type='text/javascript'>
															        swal(\"Mysql>\", \"$spli[1]\", \"success\")
															        </script>";
																}else{
  																	mysql_query("rollback;");
															        echo "<script type='text/javascript'>
															        sweetAlert(\"Usuario no guardado\", \"Error al subir la imagen\", \"error\");
															        </script>";												
															    }
															}else{
															        echo "<script type='text/javascript'>
															        sweetAlert(\"Usuario no guardado\", \"$spli[1]\", \"error\");
															        </script>";	
															}
   															mysql_free_result($result);
    														mysql_close($conexion);

													//}
											    } else {
													        echo "<script type='text/javascript'>
													        sweetAlert(\"Usuario no guardado\", \"Solo se permiten archivos de imagenes\", \"error\");
													        </script>";												   
													    }
												
											}

											?> 
						</div>
					</div>

				</div>
				
			</article>
			<!-- /Article -->

		</div>
	</div>	<!-- /container -->
	

	<footer id="footer" class="top-space">

		<div class="footer1">
			<div class="container">
				<div class="row">
					
					<div class="col-md-3 widget">
						<h3 class="widget-title">Contacto</h3>
						<div class="widget-body">
							<p>41690923<br>
								<a href="mailto:#">restore.pez@gmail.com</a><br>
								<br>
								Zona 6, Guatemala
							</p>	
						</div>
					</div>

					<div class="col-md-3 widget">
						<h3 class="widget-title">sigueme en</h3>
						<div class="widget-body">
							<p class="follow-me-icons clearfix">
								<a href=""><i class="fa fa-twitter fa-2"></i></a>
								<a href=""><i class="fa fa-dribbble fa-2"></i></a>
								<a href=""><i class="fa fa-github fa-2"></i></a>
								<a href=""><i class="fa fa-facebook fa-2"></i></a>
							</p>	
						</div>
					</div>

					<div class="col-md-6 widget">
						<h3 class="widget-title">Pagina sin fines de lucro</h3>
						<div class="widget-body">
							<p>Pagina creada, diseñada e implementada por: Jordy Alexander Gonzalez Catalan, como una proyecto del curso sistema de base de datos 2</p>
							<p>Esta pagina trata de resolver la problematica que enfrenta un gerente a la hora de administrar el control de horas de un empleado</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>
	</footer>	
		
	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="assets/js/headroom.min.js"></script>
	<script src="assets/js/jQuery.headroom.min.js"></script>
	<script src="assets/js/template.js"></script>
	<script src="http://code.jquery.com/jquery-1.6.3.min.js"></script>

</body>
</html>