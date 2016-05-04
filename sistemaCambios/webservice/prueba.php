<?php 
require_once("nusoap/nusoap.php");

function setOrden($archivo){

	$mysqli = new mysqli('localhost','gepp','gepp','gepp');

	/*
	 * Esta es la forma OO "oficial" de hacerlo,
	 * AUNQUE $connect_error estaba averiado hasta PHP 5.2.9 y 5.3.0.
	 */
	if ($mysqli->connect_error) {
	  die('Error de Conexión (' . $mysqli->connect_errno. ') '
	       . $mysqli->connect_error);
	}


	/**** Obtenemos deposito, tipo de mercado, No. de Celda y fecha con formato yyyy-mm-dd ****/
	$archivo2 = split("\.", $archivo);

	$archivo2 = $archivo2[0];

	$cadena = NULL;

	for($x=0;$x<strlen($archivo2);$x++){
		$archivo2[$x];
		$cadena .= $archivo2[$x];

		if($archivo2[$x]=='T'|| $archivo2[$x]=='M'){
			$deposito = substr($cadena, 1, -1);

			if($archivo2[$x]=='T'){
				$tipo = 0;
			}

			$tipo = 1;
			$cadena = NULL;
		}

		if($archivo2[$x]=='F'){
			$celda = substr($cadena, 1,-1);
			$cadena = NULL;

		}
	}

	$fecha = substr($cadena,4).'-'.substr($cadena,2,-4).'-'.substr($cadena,0,-6);
	
	/*** Leemos el archivo a insertar en orden ****/

	$array = file("archivos_sistema/".$archivo);

	$total = count($array);


	/** obtenemos el idoperacion para la insersion en la tabla ordenes**/
	$consulta = "SELECT idoperacion FROM operaciones WHERE idDeposito = $deposito AND mercado = $tipo LIMIT 1";
	$resultado = $mysqli->query($consulta);
	$row = $resultado->fetch_assoc();
	
	for ($i=0; $i < $total; $i++) { 
		
			$array2 = split(',',$array[$i]);
			$consulta2 .= "INSERT INTO orden (fecha, idoperacion, idRuta, nud, secuencia, sku, cSio, cequivalentes, findiseno) 
					  VALUES ('$fecha',".$row['idoperacion'].",".$array2[0].",".$array2[1].",".$array2[2].",".$array2[3].",".$array2[4].",".$array2[5].",NOW());";	
	}

	$mysqli->multi_query($consulta2);

	return $archivo;	
}

$server = new soap_server();
$server->configureWSDL("prueba","urn:prueba");

$server->register("setOrden",
	array("archivo"=>"xsd:string"),
	array("return"=>"xsd:string"),
	"urn:prueba",
	"urn:prueba#setOrden",
	"rpc",
	"encoded",
	"Leemos el archivo y guardamos en la data base");



if(isset($HTTP_RAW_POST_DATA))
{
	$input = $HTTP_RAW_POST_DATA;
}
else
{
	$input = implode("\r\n", file('php://input'));
}
$server->service($input);
exit;

?>