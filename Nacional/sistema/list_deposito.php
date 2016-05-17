<?php 
require_once("clases/class.MySQL.php");
$db = new MySQL();

$idZona = $_POST['idZona'];

$consulta = "SELECT idDeposito, deposito FROM Deposito WHERE idZona = $idZona AND estatus = 1";
$resultado = $db->consulta($consulta);
$obj = $db->fetch_object($resultado);


$arr = array();

do
{
	$arr[] = array('idDeposito'=> $obj->idDeposito,
					'deposito' => utf8_encode($obj->deposito)); 
}
while($obj = $db->fetch_object($resultado));

echo ''.json_encode($arr).'';
?>