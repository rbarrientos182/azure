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
$consulta = "SELECT cc.idcambios,cc.idcambiosMotivos,cc.idProductoCambio,cc.nud, o.idDeposito FROM CapturaCambios cc INNER JOIN operaciones o ON cc.idoperacion = o.idoperacion WHERE cc.FechaCambio = '$fecha' AND cc.idoperacion = $idoperacion AND cc.estatusDis = 0";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

do{
	//consultamos si ese cliente existe en la orden de la fecha preventa
	$consulta2 = "SELECT COUNT(fecha) AS cuantos FROM Orden WHERE fecha = '$fechaEntrega' AND idoperacion = $idoperacion AND nud = ".$row['nud'];
	$resultado2 = $db->consulta($consulta2);
	$row2 = $db->fetch_assoc($resultado2);

	//si no existe en orden significa que se fue por SIO (despacho fijo)
	if($row2['cuantos']==0) {
		
		$consulta3 = "SELECT vpp FROM Clientes WHERE nud = ".$row['nud']." AND idDeposito =".$row['idDeposito'];
		$resultado3 = $db->consulta($consulta3);
		$row3 = $db->fetch_assoc($resultado3);

		//actualizamos los cambios productos a despacho fijo
		$consulta4 = "UPDATE CapturaCambios SET idruta = ".$row3['vpp'].", estatusDis = 1 WHERE nud = ".$row['nud']." AND FechaCambio = '$fecha' AND idcambios = ".$row['idcambios']." AND idoperacion = $idoperacion AND idCambiosMotivos = ".$row['idcambiosMotivos']." AND idProductoCambio = ".$row['idProductoCambio'];
		$db->consulta($consulta4);
	} 
}while($row = $db->fetch_assoc($resultado));
?>