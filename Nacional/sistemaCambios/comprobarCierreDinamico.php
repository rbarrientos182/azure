<?php 
if (!isset($_SESSION)) 
{
	session_start();
}

include_once('clases/class.MySQL.php');

$db = new MySQL();

$idop = $_SESSION['idoperacion'];
$numempleado = $_SESSION['NumEmpleado'];
$ppp = $_SESSION['ppp'];
$fechaO = $_POST['fechaO'];

$consulta = "SELECT COUNT(*) AS cuantos FROM rutascambios WHERE idoperacion = $idop AND ruta = $ppp AND tipo = 2";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

if($row['cuantos']==1){
	
	$consulta2 = "SELECT COUNT(*) AS cuantos FROM capturacambios WHERE idoperacion = $idop AND estatusDis = 1 AND FechaCambio = $fechaO";
	$resultado2 = $db->consulta($consulta2);
	$row2 = $db->fetch_assoc($resultado2);
	if($row2['cuantos']==1){
		echo 1;
	}	
	else{
		echo 0;
	}
}
else{
	echo 0;
}
?>