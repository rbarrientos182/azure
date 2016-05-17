<?php 
require_once("clases/class.MySQL.php");
$db = new MySQL();

$idDeposito = $_POST['idDeposito'];

$consulta = "SELECT r.idRuta FROM Ruta r INNER JOIN Operaciones	o ON r.idoperacion = o.idoperacion WHERE o.idDeposito = ".$idDeposito;
$resultado = $db->consulta($consulta);
$obj = $db->fetch_object($resultado);


$arr = array();

do
{
	$arr[] = array('idRuta'=> $obj->idRuta);
	//echo $obj->idRuta; 
}
while($obj = $db->fetch_object($resultado));

echo ''.json_encode($arr).'';
?>