<?php 
class Clientes
{

	private $archivo = NULL;
	private $mysqli = NULL;


	function __construct()
	{

		$this->mysqli = new mysqli('10.50.4.5','gepp','gepp','gepp');


	}

	public function setArchivo($archivo)
	{
		$this->archivo = $archivo;
	}


	public function leerArchivo()
	{

		/*** Leemos el archivo a insertar en orden ****/

		$consulta ="LOAD DATA LOCAL INFILE 'C:\\\wamp\\\www\\\gepp\\\pagina\\\sistemaCambios\\\clientes\\\\".$this->archivo."' REPLACE INTO TABLE  clientes FIELDS TERMINATED BY '\,'";

	
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