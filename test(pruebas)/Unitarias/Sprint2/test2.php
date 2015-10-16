<?php
//test para la historias de usuario "Descontar"
class miprue2 extends PHPUnit_Framework_TestCase{
	var $aux=0;
	//probando el metodo que esta en horas.php
	function Descontar($codigo,$des,$info) {
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
	public function test2(){
		$this->assertEquals($this->Descontar(2,1,"hola mundo"),"entrando 1er periodo");
		
	}
}
