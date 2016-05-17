<?php 
require_once('clases/class.Funciones.php');

$db = new MySQL();

$id = $_GET['id'];
$tabla = 'operaciones_has_deposito';
$nombrepk = 'idcontrol';


$consulta = "DELETE FROM $tabla WHERE $nombrepk = $id";
$db->consulta($consulta);


header("Location: operaciones_deposito.php");
?>
