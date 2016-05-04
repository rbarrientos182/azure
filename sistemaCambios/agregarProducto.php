<?php if (!isset($_SESSION)) 
{
	session_start();
}

require_once('clases/class.MySQL.php');
$db = new MySQL();

$SKU= $_POST['producto'];
$Operacion= $_SESSION['idoperacion'];

$consulta = "SELECT COUNT(sku) AS cuantos FROM ProductosCambios WHERE WHERE idoperacion=$Operacion AND sku=$SKU";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);


//si existe solo actualizamos a estatus 1
if ($row['cuantos']==0) {
	$consulta2 = "UPDATE ProductosCambios SET estatus=1 WHERE idoperacion=$Operacion AND sku=$SKU";
	$db->consulta($consulta2);
}

//si no insertamos como nuevo registro
else{
	$consulta2 = "INSERT INTO ProductosCambios (idoperacion, sku, skuConver)  VALUES ($Operacion, $SKU, $SKU)";
	$db->consulta($consulta2);
}

?>