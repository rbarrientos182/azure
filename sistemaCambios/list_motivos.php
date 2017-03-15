<?php 
require_once("clases/class.MySQL.php");
$db = new MySQL();

$idAM = $_POST['idAM'];

//$consulta = "SELECT r.idRuta FROM Ruta r INNER JOIN Operaciones	o ON r.idoperacion = o.idoperacion WHERE o.idDeposito = ".$idDeposito;
$consulta="SELECT idCambiosMotivos,Descripcion  FROM CambiosMotivos WHERE agrupador='$idAM' ORDER BY Descripcion";
$resultado = $db->consulta($consulta);
$obj = $db->fetch_object($resultado);


$arr = array();

do
{
	$arr[] = array('idCambiosMotivos'=> $obj->idCambiosMotivos,'descripcion'=>$obj->Descripcion);
	//echo $obj->idRuta; 
}
while($obj = $db->fetch_object($resultado));

echo ''.json_encode($arr).'';
?>