<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();

$id = $_POST['id'];
$id2 = $_POST['id2'];
$id3 = $_POST['id3'];
$desi = $_POST['desi'];
$skuConver = $_POST['skuConver'];

$consulta = "UPDATE ProductosCambios SET  DescripcionInterna = '$desi', skuConver = $skuConver  WHERE idProductoCambio = $id AND idoperacion = $id2 AND sku = $id3";
$db->consulta($consulta);

header('Location: catalogsP.php')
?>