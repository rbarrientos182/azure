<?php
class GruposSupervisores
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

		/*** Leemos el archivo a insertar en gruposupervision ****/
		$consulta ="LOAD DATA LOCAL INFILE 'C:\\\\xampp\\\sistemaCambios\\\grupossupervisores\\\\".$this->archivo."' REPLACE INTO TABLE  gruposupervision FIELDS TERMINATED BY '\,'";


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
