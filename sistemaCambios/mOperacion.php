<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();

$id = $_POST['id'];
$id2 = $_POST['id2'];
$despacho = $_POST['despacho'];


$consulta = "UPDATE Operaciones SET coordinador_despacho = '$despacho' WHERE idoperacion = $id AND mercado = $id2";
$db->consulta($consulta);

header('Location: operaciones.php')
?>