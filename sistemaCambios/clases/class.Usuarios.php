<?php
class Usuarios
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

		/*** Leemos el archivo a insertar en gruposupervision ****/

		$consulta ="LOAD DATA LOCAL INFILE 'D:\\\home\\\site\\\wwwroot\\\sitio\\\sistemaCambios\\\usuarios\\\\".$this->archivo."' REPLACE INTO TABLE  usrcambios FIELDS TERMINATED BY '\,'";


		if(!$this->mysqli->query($consulta)){

			//printf("Errormessage: %s\n", $this->mysqli->error);
			$mensaje = $this->mysqli->error;

		}
		else{

			$mensaje = 'Grupo de Supervisores afectados fueron '.$this->mysqli->affected_rows;
		}

	return $mensaje;

	}
}
?>
