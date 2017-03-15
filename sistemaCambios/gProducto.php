<?php
if (!isset($_SESSION))
{
	session_start();
}
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$idP = $_POST['idP'];
$desIn = $_POST['desIn'];
$tipoM = $_POST['Mer'];

/*** Comprobamos si ya existe ese producto en esa operacion y en ese mercado ***/
$consulta2 = "SELECT COUNT(idProductoCambio) AS cuantos FROM ProductosCambios WHERE idoperacion=$idoperacion AND sku = $idP AND tmercado = $tipoM";
$resultado = $db->consulta($consulta2);
$row = $db->fetch_assoc($resultado);

/** si no existe se inserta como nuevo **/
if($row['cuantos']==0){
	$consulta = "INSERT INTO ProductosCambios (idoperacion,sku,DescripcionInterna,tmercado,skuConver)
	VALUES ($idoperacion,$idP,'$desIn',$tipoM,$idP)";
	$db->consulta($consulta);
}

header('Location: catalogsP.php');
?>
