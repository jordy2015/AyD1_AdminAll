<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>Administracion</title>

	<link rel="shortcut icon" href="assets/images/gt_favicon.png">
	
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="assets/css/main.css">


        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="assets/css/styles.css" />
		<!-- Font Awesome Stylesheet -->
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css" />
		<!-- Including Open Sans Condensed from Google Fonts -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700,300italic" />

</head>

<body class="home">
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
					<li class="active"><a class="btn" href="salir.php">Cerrar sesion</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->
	<!-- Header -->
	<header id="head">
		<div class="container">
			<div class="row">
				<h1 class="lead">ADMINISTRACION DE EMPLEADOS</h1>
				<p class="tagline">Menu principal del gerente </p>
				</div>
		</div>		

		<nav id="colorNav">
			<ul>
				<li class="green">
					<img src="assets/images/user.png" width="128" height="128" border="1">
					<ul>
						<li><a href="nuevo.php">Nuevo Empleado</a></li>
						<li><a href="descontar.php">Descontar Sueldo</a></li>
						<li><a href="Bajas.php">Eliminacion Empleado</a></li>
					</ul>
				</li>
				<li class="red">
					<img src="assets/images/time.png" width="128" height="128" border="1">
					<ul>
						<li><a href="horas.php">Marcar Entrada/salida</a></li>
					</ul>
				</li>
				<li class="blue">
					<img src="assets/images/money.png" width="128" height="128" border="1">
					<ul>
						<li><a href="pagos.php">Efectuar Pago diario</a></li>
					</ul>
				</li>
				<li class="yellow">
					<img src="assets/images/report.png" width="128" height="128" border="1">
					<ul>
						<li><a href="consulta1.php">Consulta 1</a></li>
						<li><a href="consulta2.php">Consulta 2</a></li>
						<li><a href="consulta3.php">Consulta 3</a></li>
						<li><a href="consulta4.php">Consulta 4</a></li>
					</ul>
				</li>
			</ul>
		</nav>			

		
	</header>
	<!-- /Header -->

	<!-- Intro -->
	<div class="container text-center">
		<br> <br>
		<h2 class="thin">Herramientas de administracion</h2>
		<p class="text-muted">
			Esta pagina ofrece un menu que contiene las funcionalidades del proyceto puede acceder a dichas <br> funcionalidades
			pasando el raton sobre los iconos que se muestran arriba 
		</p>
	</div>
	<!-- /Intro-->
		
	
	<!-- Social links. @TODO: replace by link/instructions in template -->
	<section id="social">
		<div class="container">
			<div class="wrapper clearfix">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
				<a class="addthis_button_linkedin_counter"></a>
				<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
				</div>
				<!-- AddThis Button END -->
			</div>
		</div>
	</section>
	<!-- /social links -->



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
</body>
</html>