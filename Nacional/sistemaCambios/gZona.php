<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idRegion = $_POST['idRegion'];
$zona = $_POST['zona'];
$gerente = $_POST['gerente'];

echo $consulta = "INSERT INTO Zona (idRegion, zona, gerenteZona ) VALUES ('$idRegion','$zona','$gerente')";
$db->consulta($consulta);

header('Location: zonas.php')
?>