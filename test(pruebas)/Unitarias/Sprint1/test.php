<?php
//prueba para la conexion a la base de datos
class miprue extends PHPUnit_Framework_TestCase{
	function conectar()
	{
		$conexion= mysql_connect("localhost","root","123456789") or die("No se conecto". mysql_error());
		if (!$conexion) {
			die('No pudo conectarse: ' . mysql_error());
			return false;
		}
		mysql_select_db("pract1");
		$query = mysql_query("SELECT * FROM `pract1`.`empleado` where empleado=1;");
		$result = mysql_result($query,0);
		if(!$result){
			return false;
		}
		echo 'Conectado satisfactoriamente';
		mysql_close($conexion);
		return true;
	}
	
	public function test(){
		$this->assertTrue($this->conectar2());
		
	}
}
