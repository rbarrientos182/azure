<?php
include("class.MySQL.php"); 
class Reporte extends MySQL {
	
	private $idoperacion;

	public function obtenerHeaderSegmento(){
		$consulta = "";		

	}

	public function obtenerHeaderMotivo(){

	}

	public function obtenerHeaderPresentacion(){


	}

	/**Setter **/
	public setIdoperacion($id){

		$this->idoperacion = $id;
	}
}
?>