<?php
class Rutas
{

	private $archivo = NULL;
	private $mysqli = NULL;


	function __construct()
	{

		$this->mysqli = new mysqli('pgdweb.cloudapp.net:4406','mercadeo','Eideud94@3','gepp');


	}

	public function setArchivo($archivo)
	{
		$this->archivo = $archivo;
	}


	public function leerArchivo()
	{

		/*** Leemos el archivo a insertar en rutas ****/
		$consulta ="LOAD DATA LOCAL INFILE 'C:\\\wamp\\\www\\\gepp\\\pagina\\\sistemaCambios\\\\rutas\\\\".$this->archivo."' REPLACE INTO TABLE rutascambios FIELDS TERMINATED BY '\,'";

		if(!$this->mysqli->query($consulta)){

			//printf("Errormessage: %s\n", $this->mysqli->error);
			$mensaje = $this->mysqli->error;

		}
		else{

			$mensaje = 'Rutas afectadas fueron '.$this->mysqli->affected_rows;
		}

		return $mensaje;
	}

}
?>
