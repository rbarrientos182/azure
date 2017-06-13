<?php
include_once '../class/class.MySQL.php';

$db = new MySQL();

$cadena = substr($_POST['cadena'],0, -1); //obtenemos la cadena de la tabla Tarima
$cadena = explode(';',$cadena); // convierto la cadena de la tabla tarima a un array.
$tarimaanterior = $_POST['tarima']; //obtiene el valor de la tarima seleccionada
$bandera=0;
//echo count($cadena);

for ($i=0; $i < COUNT($cadena) ; $i++) { //comenzamos con el array de tarima
	$datos = explode(',',$cadena[$i]); //creamos otro array de acuerdo al primero array
	$pk = $datos['0']; //array que contiene el pk del registro de tarima a actualizar
	$sku = $datos['1']; //sku del producto de la tarima que se va a cambiar
	$cajasanterior = $datos['2']; // cantida de cajas que se va a actualizar
	$tarimanueva = $datos[3]; //numero de la nueva tarima a donde se hara el movimiento
	$cajasnuevas = $datos[4]; //numero de cajas de la nueva tarima a donde se hara el movimiento

	$cajasdiferencia = $cajasanterior - $cajasnuevas; // hacemos la resta de las
	//cajas totales menos la cantida de cajas nuevas que se haran en el movimiento
	if ($tarimanueva!=''||$cajasnuevas!='') { //preguntamos si el campo de tarima o cajas es diferente a vacío para poder continuar
		$bandera=1;
		$query = "SELECT * FROM armadotarimas WHERE idArmadoTarimas = $pk LIMIT 1"; //seleccionamos el registro de tarima que se va a modificar
		$result = $db->consulta($query);
		$row = $db->fetch_assoc($result);

		//obtenemos la nueva secuencia a la tarima donde se pasara la nueva cantidad de cajas
		$query4 = "SELECT secuencia_sku+1 AS secuencia, tipotarima FROM armadotarimas  WHERE fecha = '".$row['fecha']."' AND numerotarima = $tarimanueva AND iddeposito = ".$row['iddeposito']." AND idruta = ".$row['idruta']." ORDER BY secuencia_sku DESC LIMIT 1";
		$result4 = $db->consulta($query4);
		$row4 = $db->fetch_assoc($result4);

		$query2 = "INSERT INTO armadotarimas (fecha,iddeposito,idruta,numerotarima,tipotarima,secuencia_sku,sku,cajas_sku,complemento,acomodo,IdTarimaAnterior,CajasAnterior,FechaAjuste)
		VALUES('".$row['fecha']."',".$row['iddeposito'].",".$row['idruta'].",".$tarimanueva.",'".$row4['tipotarima']."',".$row4['secuencia'].",".$sku.",".$cajasnuevas.",'".$row['complemento']."','".$row['acomodo']."',".$tarimaanterior.",".$cajasanterior.",NOW())";
		$db->consulta($query2);

		$query3 = "UPDATE armadotarimas SET cajas_sku=$cajasdiferencia WHERE idArmadoTarimas = $pk";
		$db->consulta($query3);

	}
}
if($bandera==1){
	$queryprocedure = "CALL actualizatarimasruta('".$row['fecha']."', ".$row['iddeposito'].",".$row['idruta'].")";
	$db->consulta($queryprocedure);
	echo 1;
}
else {
	echo 0;
}
