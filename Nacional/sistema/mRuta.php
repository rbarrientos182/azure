<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idRuta = $_POST['idRuta'];
$idOperacion = $_POST['idOperacion'];
$idUnidades = $_POST['idUnidades'];
$zona = $_POST['zona'];
$marca = $_POST['marca'];
$nEconomico = $_POST['nEconomico'];
$odometro = $_POST['odometro'];

if($zona=='')
{

	$zona = NULL;
}

if ($nEconomico=='') {
	$nEconomico = 0;
}

if($odometro==''){

	$odometro = 0;
}

$consulta = "UPDATE Ruta SET idUnidades = ".$idUnidades.", Marca = '".$marca."', Zona = '".$zona."', NumeroEconomico = ".$nEconomico.", Odometro = ".$odometro." WHERE idRuta = ".$idRuta." AND idOperacion = ".$idOperacion;
$db->consulta($consulta);

header('Location: rutas.php')

?>