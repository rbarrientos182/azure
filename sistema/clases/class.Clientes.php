<?php 
class Clientes
{

	private $archivo = NULL;
	private $mysqli = NULL;


	function __construct()
	{

		$this->mysqli = new mysqli('localhost','gepp','gepp','gepp');


	}

	public function setArchivo($archivo)
	{
		$this->archivo = $archivo;
	}


	public function leerArchivo()
	{

		/*** Leemos el archivo a insertar en orden ****/
		$dir = 'xampp';

		$consulta ="LOAD DATA LOCAL INFILE 'C:\\\\xampp\\\htdocs\\\gepp\\\pagina\\\sistema\\\clientes\\\\".$this->archivo."' REPLACE INTO TABLE  clientes FIELDS TERMINATED BY '\,'";

		if(!$this->mysqli->query($consulta)){

			//printf("Errormessage: %s\n", $this->mysqli->error);
			$mensaje = $this->mysqli->error;

		}
		else{

			$mensaje = 'Clientes afectados fueron '.$this->mysqli->affected_rows;
		}

	return $mensaje;

	}	
}
?>