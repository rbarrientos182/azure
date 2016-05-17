<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idDeposito = $_POST['idDeposito'];
$idOp = $_POST['idOp'];
$totalReg = $_POST['totalReg'];
$fechas = json_decode($_POST["fechas"], true);
$tExc = json_decode($_POST["tExc"], true);
$cEsp = json_decode($_POST["cEsp"], true);
$dis = json_decode($_POST["dis"], true);
$eInf = json_decode($_POST["eInf"], true);
$rInf = json_decode($_POST["rInf"], true);
$obs = json_decode($_POST["obs"], true);


try {

	for($x=0; $x<$totalReg;$x++)
	{
		//echo $fechas[$x];
		//echo $tExc[$x];
		//echo $cEsp[$x];
		//echo $dis[$x];
		//echo $eInf[$x];
		//echo $rInf[$x];
		//echo $obs[$x];
		$consulta = "INSERT INTO tiempos (idDeposito, fecha, tiempoExcedido, colaEspera, disenio, fin, inicio, tipo) 
					 VALUES ($idDeposito,'".$fechas[$x]."','".$tExc[$x]."','".$cEsp[$x]."','".$dis[$x]."','".$eInf[$x]."','".$rInf[$x]."','".$obs[$x]."')";
		$db->consulta($consulta);
		$db->liberar($consulta);
	}


} catch (Exception $e) {

	echo $e;
	
}
?>