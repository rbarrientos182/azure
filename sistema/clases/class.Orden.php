<?php 
class Orden {

	private $archivo = NULL;
	private $idDeposito = NULL;
	private $fecha = NULL;
	private $mysqli = NULL;


	function __construct(){

		$this->mysqli = new mysqli('localhost','gepp','gepp','gepp');


	}
	public function setArchivo ($archivo){
		$this->archivo = $archivo;
		
	}


	public function leerArchivo(){

		$consulta ="LOAD DATA LOCAL INFILE 'C:\\\\xampp\\\htdocs\\\gepp\\\pagina\\\sistema\\\Ordenes\\\\".$this->archivo."' REPLACE INTO TABLE orden FIELDS TERMINATED BY '\,'";

		if(!$this->mysqli->query($consulta)){

			printf("Errormessage: %s\n", $this->mysqli->error);

		}

	}
		
}
?>