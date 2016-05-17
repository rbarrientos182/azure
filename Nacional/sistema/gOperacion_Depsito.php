<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

 $idUsuario = $_POST['idU'];
 $idDeposito = $_POST['idD'];
 $Tipo = $_POST['tipo'];

try {

	$consulta = "INSERT INTO operaciones_has_deposito (idoperaciones,iddeposito,idusuarios) VALUES ($Tipo,$idDeposito,$idUsuario)";
	$db->consulta($consulta);
	
} catch (Exception $e) {


}


header("Location: operaciones_deposito.php");

//cho "Entro";
?>