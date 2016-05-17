<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idNivel = $_POST['idNivel'];
$nivel = $_POST['nivel'];
$descripcion = $_POST['descripcion'];

$consulta = "UPDATE Nivel SET nivel = '$nivel', descripcion = '$descripcion' WHERE idNivel = $idNivel";
$db->consulta($consulta);

header('Location: niveles.php')

?>