<?php
class Clientes
{
	private $dir = NULL;
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

		/*/site/wwwroot/sitio/sistema/clientes*/
		/*** Leemos el archivo a insertar en orden ****/
		$consulta ="LOAD DATA LOCAL INFILE 'D:\\\home\\\site\\\wwwroot\\\sitio\\\sistema\\\clientes\\\\".$this->archivo."' REPLACE INTO TABLE  clientes FIELDS TERMINATED BY '\,'";

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
