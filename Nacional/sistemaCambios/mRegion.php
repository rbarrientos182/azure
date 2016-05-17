<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

$id = $_POST['idRegion'];
$director = $_POST['director'];
$correo = $_POST['correo'];


$consulta = "UPDATE Region SET director = '$director', correo = '$correo' WHERE idRegion = $id";
$db->consulta($consulta);

header('Location: regiones.php')
?>