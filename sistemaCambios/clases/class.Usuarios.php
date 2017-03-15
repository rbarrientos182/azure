<?php
class Usuarios
{

	private $archivo = NULL;
	private $mysqli = NULL;


	function __construct()
	{

		$this->mysqli = new mysqli('locahost','gep','gepp','gepp');


	}

	public function setArchivo($archivo)
	{
		$this->archivo = $archivo;
	}


	public function leerArchivo()
	{

		/*** Leemos el archivo a insertar en usuarios cambios ****/
		$consulta ="LOAD DATA LOCAL INFILE 'D:\\\home\\\site\\\wwwroot\\\sitio\\\sistemaCambios\\\usuarios\\\\".$this->archivo."' REPLACE INTO TABLE  usrcambios FIELDS TERMINATED BY '\,'";


		if(!$this->mysqli->query($consulta)){

			//printf("Errormessage: %s\n", $this->mysqli->error);
			$mensaje = $this->mysqli->error;

		}
		else{

			$mensaje = 'Usuarios afectados fueron '.$this->mysqli->affected_rows;
		}

	return $mensaje;

	}
}
?>
