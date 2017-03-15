<?php
if (!isset($_SESSION))
{
	session_start();
}
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$id = $_POST['id'];
$id2 = $_POST['id2'];
$idP = $_POST['idP'];
$desIn = $_POST['desIn'];
$tipoM = $_POST['Mer'];
$estatus = $_POST['estatus'];

/*** Comprobamos si ya existe ese producto en esa operacion y en ese mercado ***/
$consulta2 = "SELECT COUNT(idProductoCambio) AS cuantos FROM ProductosCambios WHERE idoperacion=$idoperacion AND sku = $id2 AND tmercado = $tipoM";
$resultado = $db->consulta($consulta2);
$row = $db->fetch_assoc($resultado);


/** si existe se actualiza**/
if($row['cuantos']==1){
	$consulta = "UPDATE ProductosCambios SET  DescripcionInterna = '$desIn', estatus = $estatus, tmercado = $tipoM  WHERE idProductoCambio = $id AND idoperacion = $idoperacion AND sku = $id2";
	$db->consulta($consulta);
}
header('Location: catalogsP.php')
?>
