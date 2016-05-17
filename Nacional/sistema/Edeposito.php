<?php 
require_once('clases/class.Funciones.php');

$db = new MySQL();

$id = $_GET['id'];
$tabla = 'deposito';
$nombrepk = 'iddeposito';


$consulta = "DELETE FROM $tabla WHERE $nombrepk = $id";
$db->consulta($consulta);


header("Location: depositos.php");
?>

