<?php if (!isset($_SESSION)) 
{
	session_start();
}

require_once('clases/class.MySQL.php');
$db = new MySQL();

$SKU= $_POST['producto'];
$Operacion= $_SESSION['idoperacion'];

$consulta = "UPDATE ProductosCambios SET estatus=0 WHERE idoperacion=$Operacion AND sku=$SKU";
$db->consulta($consulta);

?>