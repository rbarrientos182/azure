<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idzona = $_POST['idzona'];
$idRegion = $_POST['idRegion'];
$zona = $_POST['zona'];
$gerente = $_POST['gerente'];

echo $consulta = "UPDATE Zona SET idRegion = $idRegion, zona = '$zona', gerenteZona = '$gerente' WHERE idzona = ".$idzona;
$db->consulta($consulta);

header('Location: zonas.php')
?>