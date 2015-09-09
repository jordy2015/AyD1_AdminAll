<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>Marcar</title>

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
	<!--<?php
	/*	session_start();
	if($_SESSION['ingreso']!="bien"){
			header("Location: http://localhost/signin.php");
	}*/
	?>-->
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
					<li><a href="horas.php">Refrescar</a></li>
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
			<li class="active">Marcar</li>
		</ol>

		<div class="row">
			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="page-title">Marcar</h1>
				</header>	
				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="thin text-center">Marcar Entrada/Salida</h3>
							<p class="text-center text-muted">Ingrese el codigo del empleado en el campo para marcar la entrada/salida el sistema sabra si el empĺeado esta entrando o saliendo y tomara en cuenta 
							que el empleado puede tomar dos turnos de trabajo durante un dia.</p>
							<hr>
							<form method="post" action="horas.php">
								<div class="top-margin">
									<center><label>Ingrese codigo de empleado <span class="text-danger">*</span></label><br></center>								
									<center><input name="codigo" id="codigo" type="text" class="form-control"  pattern="^\d*[0-9]" required/></center>
								</div>
								<hr>
								<div class="row">
									<div class="col-lg-8"></div>
									<div class="col-lg-4 text-right">
										<button name="marcar" class="btn btn-action" type="submit">Marcar</button>
									</div>
								</div>

								<?php
								if (isset($_POST['marcar'])) {
									$codigo=$_POST['codigo'];
									Marcar($codigo);
								}
							
								function Marcar($codigo) {
									$conexion= mysql_connect("localhost","root","123456789") or die("No se conecto". mysql_error());
									mysql_select_db("pract1");
									$query = mysql_query("select Marcar(".$codigo.");");   															
									$result = mysql_result($query,0);
									$tipo=explode("-",$result);
									if($tipo[0]==0){
										echo "
										<script type=\"text/javascript\">
											swal({   
											title: \"Mysql>\",   
											text: \"$tipo[1]\",      
											imageUrl: \"$tipo[2]\",
											imageSize: \"200x200\",     
											confirmButtonColor: \"#AEDEF4\",   
											confirmButtonText: \"OK\",   
											closeOnConfirm: false }, 
											function(){   
												window.location = \"http://localhost/horas.php\"
											});
										</script>
										";

									}else{
										echo "
										<script type=\"text/javascript\">
											swal({   title: \"Error!\",   
											text: \"$tipo[1]\",   
											type: \"error\",      
											confirmButtonColor: \"#DD6B55\",   
											confirmButtonText: \"OK\",   
											closeOnConfirm: false }, 
											function(){   
												window.location = \"http://localhost/horas.php\"
											});
										</script>
										";
									}

									mysql_free_result($result);
									mysql_close($conexion);	
								}
								?>
							</form>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>
	
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