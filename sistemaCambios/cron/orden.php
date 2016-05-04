<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");




$mysqli = new mysqli('localhost','gepp','gepp','gepp');
/*
* Esta es la forma OO "oficial" de hacerlo,
* AUNQUE $connect_error estaba averiado hasta PHP 5.2.9 y 5.3.0.
*/
if ($mysqli->connect_error) {
	 die('Error de Conexión (' . $mysqli->connect_errno. ') '
	    . $mysqli->connect_error);
}
	
/*** Consultamos la tabla de ***/
$consulta = "SELECT  NombreArchivo FROM procesaorden WHERE Estatus = 0 ORDER BY Fecha DESC";
$resultado = $mysqli->query($consulta);
$row = $resultado->fetch_assoc();

do
{
	$mysqli = new mysqli('localhost','gepp','gepp','gepp');
	$mysqli2 = new mysqli('localhost','gepp','gepp','gepp');
/*
* Esta es la forma OO "oficial" de hacerlo,
* AUNQUE $connect_error estaba averiado hasta PHP 5.2.9 y 5.3.0.
*/
if ($mysqli->connect_error) {
	 die('Error de Conexión (' . $mysqli->connect_errno. ') '
	    . $mysqli->connect_error);
}
	echo $archivo = $row['NombreArchivo'].'.csv';
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

			else{

				$tipo = 1;
			}

			
			$cadena = NULL;
		}

		if($archivo2[$x]=='F'){
			$celda = substr($cadena, 1,-1);
			$cadena = NULL;

		}
	}

	$fecha = substr($cadena,4).'-'.substr($cadena,2,-4).'-'.substr($cadena,0,-6);
		
	/*** Leemos el archivo a insertar en orden ****/

	$array = file("../webservice/archivos_sistema/".$archivo);
	echo '<br>';
	echo $total = count($array);
	echo '<br>';

	/** obtenemos el idoperacion para la insersion en la tabla ordenes**/
	
		echo $consulta2 = "SELECT idoperacion FROM operaciones WHERE idDeposito = $deposito AND mercado = $tipo LIMIT 1";
		$resultado2 = $mysqli->query($consulta2);
		echo $row2 = $resultado2->fetch_assoc();
		
		echo 'salio consulta 2';
		$consulta3 = NULL;	
		for ($i=0; $i < $total; $i++) { 
		
		 	$array2 = split(',',$array[$i]);
			$consulta3 .= "INSERT INTO orden (fecha, idoperacion, idRuta, nud, secuencia, sku, cSio, cequivalentes, findiseno) 
							VALUES ('$fecha',".$row2['idoperacion'].",".$array2[0].",".$array2[1].",".$array2[2].",".$array2[3].",".$array2[4].",".$array2[5].",NOW());";	
		}

		echo '<br>';
		echo $consulta3;
		echo '<br>';
		
$mysqli->multi_query($consulta3);
/*** Actualizamos el estatus del archivo que se leyo a leido =1 ***/
$consulta4 = "UPDATE procesaorden SET estatus = 1 WHERE NombreArchivo = '".$row['NombreArchivo']."' AND estatus = 0";
$mysqli2->query($consulta4);

} while($row = $resultado->fetch_assoc());
$mysqli->free();
$mysqli2->free();
?>