<?php 
class Productos
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

		/*** Leemos el archivo a insertar en productos ****/

		$consulta ="LOAD DATA LOCAL INFILE 'C:\\\wamp\\\www\\\gepp\\\pagina\\\sistema\\\productos\\\\".$this->archivo."' REPLACE INTO TABLE productos FIELDS TERMINATED BY '\,'";

		if(!$this->mysqli->query($consulta)){

			printf("Errormessage: %s\n", $this->mysqli->error);

		}
	}	

}
?>