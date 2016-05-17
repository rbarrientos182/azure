<?php 
require_once("clases/class.MySQL.php");
$db = new MySQL();

$idregion = $_POST['idregion'];

$consulta = "SELECT idZona, zona FROM zona WHERE idRegion = $idregion ORDER BY zona";
$resultado = $db->consulta($consulta);
$obj = $db->fetch_object($resultado);


$arr = array();

do
{
	$arr[] = array('idZona'=> $obj->idZona,
					'zona' => utf8_encode($obj->zona)); 
}
while($obj = $db->fetch_object($resultado));

echo ''.json_encode($arr).'';
?>