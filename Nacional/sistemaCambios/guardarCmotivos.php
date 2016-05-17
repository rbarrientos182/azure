<?php 
if (!isset($_SESSION)) 
{
	session_start();
}
include_once('clases/class.CambiosMotivos.php');
include_once('clases/class.MySQL.php');

$cMotivos = new CambiosMotivos();
$db = new MySQL();

$noEmpleado = $_SESSION['NumEmpleado'];
$idop = $_SESSION['idoperacion'];
$itemsEnCesta = $_SESSION['itemsEnCesta'];

/** array dias **/
$dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');


/*** Obtener la descripcion del motivo ***/
foreach($itemsEnCesta as $k => $v)
{	
	$fechaDia = $dias[date('N', strtotime($v['fechaE']))];

	if($fechaDia=='Sabado'){
		$fechaEntrega = strtotime ('+2 day', strtotime ($v['fechaE']));
	}
	else
	{
		$fechaEntrega = strtotime ('+1 day', strtotime ($v['fechaE']));
	}

	$fechaEntrega = date('Y-m-j', $fechaEntrega);

	$consultaRuta = "SELECT c.vpp,rc.tipo, COUNT(rc.ruta) AS cuantos FROM operaciones o 
	INNER JOIN clientes c ON o.idDeposito = c.idDeposito 
	INNER JOIN rutasCambios rc ON o.idoperacion = rc.idoperacion
	AND o.idoperacion = $idop
	AND c.nud = ".$v['nud']."
	AND c.ppp = rc.ruta";
	$resultadoRuta = $db->consulta($consultaRuta);
	$rowRuta = $db->fetch_assoc($resultadoRuta);

	if($rowRuta['tipo'] == 1){
		
		$consulta = "INSERT INTO  CapturaCambios(idOperacion,NumEmpleado,idCambiosMotivos,idProductoCambio,FechaCambio,cantidad,nud,fechaEntrega,idruta,estatusDis,horaCaptura) VALUES ($idop,$noEmpleado,".$v['idM'].",".$v['sku'].",'".$v['fechaE']."',".$v['cantidad'].",".$v['nud'].",'".$fechaEntrega."',".$rowRuta['vpp'].",2,NOW())";
	}

	else{
		$consulta = "INSERT INTO  CapturaCambios(idOperacion,NumEmpleado,idCambiosMotivos,idProductoCambio,FechaCambio,cantidad,nud,fechaEntrega,horaCaptura) VALUES ($idop,$noEmpleado,".$v['idM'].",".$v['sku'].",'".$v['fechaE']."',".$v['cantidad'].",".$v['nud'].",'".$fechaEntrega."',NOW())";
	}
	$resultado = $db->consulta($consulta);
	$row = $db->fetch_assoc($resultado);
}
unset($_SESSION['itemsEnCesta']);
$cMotivos->mostrarTabla();
?>