<?php
if (!isset($_SESSION)) 
{
	session_start();
}
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$ruta = $_POST['ruta'];
$tipoR = $_POST['tipoR'];
$estatusR = $_POST['estatusR'];
$tipoM = $_POST['tipoM'];
$nGrupo = $_POST['nGrupo'];

$consulta2 = "SELECT COUNT(ruta) AS cuantos FROM rutasCambios WHERE idoperacion=$idoperacion AND ruta = $ruta";
$resultado = $db->consulta($consulta2);
$row = $db->fetch_assoc($resultado);

if($row['cuantos']==0){
	$consulta = "INSERT INTO rutasCambios (idoperacion,idgruposupervision,ruta,tipo,estatus,tMercado) VALUES ($idoperacion,$nGrupo,$ruta,$tipoR,$estatusR,$tipoM)";
	$db->consulta($consulta);	
}
header('Location: rutas.php');
?>