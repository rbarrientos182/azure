<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

$tipo = $_POST['tipo'];
$palets = $_POST['palets'];
$tpalets = $_POST['tpalets'];

$capacidad = $palets * 55;// se calcula la capacida de la unidad de acuerdo a la cantida de palets que se tiene por 55
$consulta = "INSERT INTO Unidades (Tipo,capacidad,palets,TipoDePalet) VALUES ($tipo,$capacidad,$palets,$tpalets)";
$db->consulta($consulta);

header('Location: unidades.php')

?>