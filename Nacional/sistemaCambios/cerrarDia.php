<?php if (!isset($_SESSION)) 
{
	session_start();
}

require_once('clases/class.MySQL.php');
$db = new MySQL();

$fecha= $_POST['fecha'];
$idoperacion= $_SESSION['idoperacion'];


//$fecha = date('l', strtotime($fecha));
$dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
$fechaDia = $dias[date('N', strtotime($fecha))];

//echo 'fecha preventa es '.$fecha.' dia es '.$fechaDia;


if($fechaDia=='Sabado'){

	$fechaEntrega = strtotime ('+2 day', strtotime ($fecha));

}
else{

	$fechaEntrega = strtotime ('+1 day', strtotime ($fecha));
}

$fechaEntrega = date('Y-m-j', $fechaEntrega);

//consultamos todos los clientes que tienen cambios
$consulta = "SELECT cc.idcambios,cc.idcambiosMotivos,cc.idProductoCambio,cc.nud, o.idDeposito FROM CapturaCambios cc INNER JOIN operaciones o ON cc.idoperacion = o.idoperacion WHERE cc.FechaCambio = '$fecha' AND cc.idoperacion = $idoperacion AND ISNULL(cc.estatusDis)";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

do{		//obtenemos su vpp en la tabla clientes
		$consulta3 = "SELECT ppp,vpp FROM clientes WHERE nud = ".$row['nud']." AND iddeposito =".$row['idDeposito'];
		$resultado3 = $db->consulta($consulta3);
		$row3 = $db->fetch_assoc($resultado3);

		$consulta4 = "SELECT ruta, tipo FROM rutasCambios WHERE ruta = ".$row3['ppp']." AND idoperacion = $idoperacion";
		$resultado4 = $db->consulta($consulta4);
		$row4 = $db->fetch_assoc($resultado4);

		// comprobamos que la ruta es para despachos que no tengan dinámico, fijo
		if($row4['tipo']==1){
			//actualizamos los cambios productos a despacho fijo
			echo $consulta5 = "UPDATE CapturaCambios SET idruta = ".$row3['vpp'].", estatusDis = 2 WHERE idcambios = ".$row['idcambios'];
			$db->consulta($consulta5);	
		}

		
}while($row = $db->fetch_assoc($resultado));
?>