<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>Descuento</title>

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
					<li><a href="descontar.php">Refrescar</a></li>
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
			<li class="active">Descuento</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-sm-9 maincontent">
				<header class="page-header">
					<h1 class="page-title">Descuentos empleados</h1>
				</header>
				
				<p>
					Use esta pagina para descontar al empleado que por alguna en especifico se le tiene que aplicar la sancion
					para que el descuento sea valido se necesita que llene todos los campos.
				</p>
				<br>
					<form method="post" action="descontar.php">
						<div class="row">
							<div class="col-sm-4">
								<input name="codigo" class="form-control" type="text" placeholder="Codigo empleado" pattern="^\d*[0-9]" required/>
							</div>
							<div class="col-sm-4">
								<input name="desc" class="form-control" type="text" placeholder="Cantidad a descontar" pattern="^\d*[0-9](|.\d*[0-9]|)*$" required/>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-12">
								<textarea name="info" placeholder="Informe completo" class="form-control" rows="9" required/></textarea>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-6">
							
							</div>
							<div class="col-sm-6 text-right">
							<button name="quitar" class="btn btn-action" type="submit">Registrar</button>
							</div>
						</div>

					<?php 
						if (isset($_POST['quitar'])) {
							$codigo=$_POST['codigo'];
							$des=$_POST['desc'];
							$info=$_POST['info'];
							$conexion= mysql_connect("localhost","root","123456789") or die("No se conecto". mysql_error());
							mysql_select_db("pract1");
							$query = mysql_query("CALL `pract1`.`Descontar`(".$codigo.",'".$info."','".$des."');");   															
							$result = mysql_result($query,0);
							if($result==""){
						        echo "<script type='text/javascript'>
						        swal(\"Mysql>\", \"Completado\", \"success\")
						        </script>";
							}else{
						        echo "<script type='text/javascript'>
						        swal(\"Mysql>\", \"$result\", \"error\")
						        </script>";
							}
							mysql_free_result($result);
							mysql_close($conexion);	
						}
					 ?>


					</form>
			</article>
			<!-- /Article -->
			
			<!-- Sidebar -->
			<aside class="col-sm-3 sidebar sidebar-right">

				<div class="widget">
					<h4>Oficinas de campero</h4>
					<address>
						Guatemala zona 10
					</address>
					<h4>Telefono:</h4>
					<address>
						(502) 2791-1414
					</address>
				</div>

			</aside>
			<!-- /Sidebar -->

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