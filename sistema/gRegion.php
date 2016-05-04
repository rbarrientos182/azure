<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

$region = $_POST['region'];

$consulta = "INSERT INTO Region (region) VALUES ('$region')";
$db->consulta($consulta);

header('Location: regiones.php')

?>