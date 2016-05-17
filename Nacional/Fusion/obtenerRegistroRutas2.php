<?php 
// Desactivar toda notificación de error
error_reporting(0);

require_once("clases/class.MySQL.php");
require_once("clases/class.Utilidades.php");

$mysqli = new MySQL();
$uti = new Utilidades();

$idoperacion = $_POST['idoperacion'];

$consulta = "SELECT count(idRuta) AS cuantos FROM Ruta WHERE idoperacion = $idoperacion ORDER BY cuantos DESC";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

 $cuantos = $row['cuantos'];
 $cuantos = round($cuantos);
 echo $cuantos;
?>