<?php

//test para la historia de usuario "marcar"
class miprue extends PHPUnit_Framework_TestCase{
	var $aux=0;
	//probando el metodo que esta en horas.php
	function Marcar($codigo) {
		$conexion= mysql_connect("localhost","root","123456789") or die("No se conecto". mysql_error());
		mysql_select_db("pract1");
		$query = mysql_query("select Marcar(".$codigo.");");   															
		$result = mysql_result($query,0);
		$tipo=explode("-",$result);
		if($tipo[0]==0){
			$this->aux++;
		}else{
			$this->aux--;
		}
		mysql_free_result($query);
		mysql_close($query);	
		return $tipo[1];
	}	
	public function test(){
		$this->assertEquals($this->Marcar(2),"entrando 1er periodo");
		//$this->assertEquals($this->Marcar(2),"saliendo 1er periodo");
		//$this->assertEquals($this->Marcar(2),"entrando 2do periodo");
		//$this->assertEquals($this->Marcar(2),"saliendo 2do periodo");
		//$this->assertEquals($this->Marcar(2),"El empleado ya completo los 2 periodos del dia");
		
	}
}
