<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idDeposito = $_POST['idDeposito'];
$mercado = $_POST['mercado'];
$despacho = $_POST['despacho'];


$consulta = "SELECT idDeposito FROM Operaciones WHERE idDeposito = ".$idDeposito." AND mercado = ".$mercado." LIMIT 1";
$resultado = $db->consulta($consulta);
$numRow = $db->num_rows($resultado);

if($numRow==0){
	$consulta2 = "INSERT INTO Operaciones (idDeposito,mercado,coordinador_despacho) VALUES ($idDeposito,$mercado,'$despacho')";
	$db->consulta($consulta2);
}

header('Location: operaciones.php')
?>