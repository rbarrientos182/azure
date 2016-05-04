<?php 
$mysqli = new mysqli('localhost','gepp','gepp','gepp');


$array = file($this->archivo);

	$total = count($array);

	for ($i=0; $i < $total; $i++) { 
		
			$array2 = split(',',$array[$i]);

			/*** Comprobamos si el cliente a insertar ya existe en la tabla, si es asi se procede a un update***/
			$consulta = "SELECT nud FROM Clientes WHERE nud = ".$array2[0]." LIMIT 1";
			$resultado = $mysqli->query($consulta);
			$num_row = $resultado->num_rows;

		}

			/*** preguntamos si hay un registro, si se cumple quiere decir que ese cliente ya esta en la base de datos por lo cual
				se arma un update en caso contrario un insert	
			 ***/

			if($num_row==1){
				$consulta2 .= "UPDATE Clientes 	SET ppp = ".$array2[1].", vpp = ".$array2[2].", nombre = '".$array2[3]."', direccion = '".$array2[4]."',
								calleizq = '".$array2[5]."', calleder = '".$array2[6]."', localidad = '".$array2[7]."', municipio = '".$array2[8]."', 
								colonia = '".$array2[9]."', vacia = '".$array2[10]."', cp = ".$array2[11].", telefono = ".$array2[12].", giro = ".$array2[13]." ,
								categoria = '".$array2[14]."', volPromSem = ".$array2[15].", tipoFrecuencia = '".$array2[16]."', dia = '".$array2[17]."',
								frecuencia = ".$array2[18].", concatena = ".$array2[20].", f1 = ".$array2[21].", f2 = ".$array2[22].", latitud = ".$array2[23].",
								longitud = ".$array2[24].", alta = ".$array2[25].", volAcum = ".$array2[26].", semanas = ".$array2[27]." 
								WHERE nud = ".$array2[0]." AND iddeposito = ".$array2[19].";";
			}
			else{

				$consulta2 .= "INSERT INTO Clientes (nud, ppp, vpp, nombre, direccion, calleizq, calleder, localidad, municipio, colonia, vacia, cp, telefono, giro,
								categoria, volPromSem, tipoFrecuencia, dia, frecuencia, iddeposito, concatena, f1, f2, latitud, longitud, alta, volAcum, semanas)
								VALUES (".$array2[0].",".$array2[1].",".$array2[2].",".$array2[3].",".$array2[4].",".$array2[5].",".$array2[6].",".$array2[7].",".$array2[8]."
									,".$array2[9].",".$array2[10].",".$array2[11].",".$array2[12].",".$array2[13].",".$array2[14].",".$array2[15].",".$array2[16].",".$array2[17]."
									,".$array2[18].",".$array2[19].",".$array2[20].",".$array2[21].",".$array2[22].",".$array2[23].",".$array2[24].",".$array2[25].",".$array2[26]."
									,".$array2[27].");";			
			}

	}
	//echo 'entro';

	echo $consulta2;
	//$this->mysqli->multi_query($consulta2);
?>