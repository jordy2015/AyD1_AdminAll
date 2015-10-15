<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>Consulta No. 4</title>


  <script src="assets/js/swal/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="assets/js/swal/sweetalert.css">

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
					<li><a href="consulta4.php">Refrescar</a></li>
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
			<li class="active">Consultas</li>
		</ol>

		<div class="row">
			<!-- Article main content -->
			<article class="col-sm-8 maincontent">
				<header class="page-header">
					<h1 class="page-title">Consulta No. 4</h1>
				</header>
				
				<form method="post" action="consulta4.php">
				<div class="row">
					<div class="col-sm-4">
					<input name="mes" class="form-control" type="text" placeholder="Mes a buscar" pattern="^\d*[0-9]" required/>
					</div>
					<div class="col-sm-4">
					<input name="anio" class="form-control" type="text" placeholder="Año a buscar" pattern="^\d*[0-9]" required/>
					</div>
					<div class="col-sm-4">
					<input name="Idempl" class="form-control" type="text" placeholder="Codigo empleado a buscar" pattern="^\d*[0-9]" required/>
					</div>
				</div>
				<br>
				<br>
				<center>
				<button name="actualizar" class="btn btn-action" type="submit">Consultar</button>
				<button name="generar" class="btn btn-action" type="submit">Generar pdf</button>
				</center>
				</form>
				<?php
					function download_file($archivo, $downloadfilename = null) {
					    if (file_exists($archivo)) {
					        $downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
					        header('Content-Description: File Transfer');
					        header('Content-Type: application/octet-stream');
					        header('Content-Disposition: attachment; filename=' . $downloadfilename);
					        header('Content-Transfer-Encoding: binary');
					        header('Expires: 0');
					        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					        header('Pragma: public');
					        header('Content-Length: ' . filesize($archivo));
					        ob_clean();
					        flush();
					        readfile($archivo);
					        exit;
					    }
					}

					require_once("assets/dompdf/dompdf_config.inc.php");
					if(isset($_POST['actualizar'])){
					inicio();
					}

					if(isset($_POST['generar'])){
						$servername = "localhost";
						$username = "root";
						$password = "123456789";
						$dbname = "pract1";

						$mes=$_POST['mes'];
						$anio=$_POST['anio'];
						$idem=$_POST['Idempl'];
						// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);
						// Check connection
						if ($conn->connect_error) {
						    die("Connection failed: " . $conn->connect_error);
						} 
						$codigoHTML='
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Lista</title>
						</head>
						<body>
											<center><h1>Consulta No. 4</h1></center>
											<p>Reporte donde se detalla el nombre, dias laborados, total ganado, total de horas realizadas y descuentos de un empleado dado en un mes dado y un año dado, en este caso para el empleado con ID: '.$idem.', en el mes: '.$mes.', año: '.$anio.'<p>

						<div align="center">
						    <table width="100%" border="1">
								<tr>
								<th>Nombre</th>
								<th>Dia</th>
								<th>Total ganado (Q)</th>
								<th>Horas trabajadas</th>
								<th>Descuentos</th>
								</tr>';

							$sql = "CALL ReporteMensual($mes, $anio, $idem);";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
							     while($row = $result->fetch_assoc()) {
									$codigoHTML.='
									      <tr>
									        <td>'.$row['nombre'].'</td>
									        <td>'.$row['dia'].'</td>
									        <td>'.$row['total'].'</td>
									        <td>'.$row['hr'].'</td>
									        <td>'.$row['descueto'].'</td>
									      </tr>';
							     }
							   		$codigoHTML.='
									</table>
									</div>
									</body>
									</html>';
								    $dompdf = new DOMPDF();
								    $dompdf->load_html($codigoHTML);
								    $dompdf->render();
								    file_put_contents('./reportes/reporte.pdf', $dompdf->output());
								    download_file("reportes/reporte.pdf", "reporte4.pdf");
							} else {
							    echo "<script>
							    swal(\"!Vacio¡\", \"No hay datos\", \"warning\");
							    </script>";
							}
							$conn->close();
					}
				?>
				<hr>
				<center>
				<table id="tabla1" border="1" width="100%">
				<tr>
				<th>Nombre</th>
				<th>Dias laborados</th>
				<th>Total (Q)</th>
				<th>Total (hr)</th>
				<th>Total descuentos(Q)</th>
				</tr>
				</table>
				</center>
				<?php 
				function inicio(){
					$servername = "localhost";
					$username = "root";
					$password = "123456789";
					$dbname = "pract1";
					$mes=$_POST['mes'];
					$anio=$_POST['anio'];
					$idem=$_POST['Idempl'];
					// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					// Check connection
					if ($conn->connect_error) {
					    die("Connection failed: " . $conn->connect_error);
					} 
					$sql = "CALL ReporteMensual($mes, $anio, $idem);";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
							echo "<script>		
								 window.onload = function(){						
								 var table = document.getElementById(\"tabla1\");
								";
					     while($row = $result->fetch_assoc()) {
								echo "
									var row = table.insertRow(1);
								    var cell1 = row.insertCell(0);
								    var cell2 = row.insertCell(1);
								    var cell3 = row.insertCell(2);
								    var cell4 = row.insertCell(3);
								    var cell5 = row.insertCell(4);
								    cell1.innerHTML = \"$row[nombre]\";
								    cell2.innerHTML = \"$row[dia]\";
								    cell3.innerHTML = \"$row[total]\";
								    cell4.innerHTML = \"$row[hr]\";
								    cell5.innerHTML = \"$row[descueto]\";
								";
					     }
					     echo 	"}
					     		</script>";
					} else {
					    echo "<script>
					    swal(\"!Vacio¡\", \"No hay datos\", \"warning\");
					    </script>";
					}
					$conn->close();
				}

				?>

			</article>
			<!-- /Article -->
			
			<!-- Sidebar -->
			<aside class="col-sm-4 sidebar sidebar-right">

				<div class="widget">
					<h4>Consultas</h4>
					<ul class="list-unstyled list-spaces">
						<li><a href="consulta1.php">Consulta No. 1</a><br><span class="small text-muted">Reporte donde se detalla el nombre, ID, dias laborados, total ganado hasta ahora, total de horas realizadas que los empleados han realizado desde inicio del mes actual, hasta ahora.</span></li>
						<li><a href="consulta2.php">Consulta No. 2</a><br><span class="small text-muted">Reporte donde se detalla el nombre y ID de las personas que por algun motivo tienen descuentos en el mes actual.</span></li>
						<li><a href="consulta3.php">Consulta No. 3</a><br><span class="small text-muted">Reporte donde se detalla el nombre, total ganado durante el dia actual, total de horas trabajadas durante el dia actual (reporte se puede visualizar solo cuando se ha realizado el pago diario).</span></li>
						<li><a href="consulta4.php">Consulta No. 4</a><br><span class="small text-muted">Reporte donde se detalla el nombre, dias laborados, total ganado, total de horas realizadas y descuentos de un empleado dado en un mes dado y un año dado.</span></li>
					</ul>
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