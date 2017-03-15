<?php 
// Desactivar toda notificación de error
error_reporting(0);

require_once("clases/class.MySQL.php");
require_once("clases/class.Utilidades.php");

$mysqli = new MySQL();
$uti = new Utilidades();

$intervalo = $uti->obtenerIntervalo();
$iddeposito = $_POST['iddeposito'];
$tipoRuta = $_POST['tipoRuta'];

$consulta = "SELECT COUNT(idRuta) AS cuantos FROM resumen_ruta  WHERE iddeposito = $iddeposito AND tipoRuta = $tipoRuta AND fechaOperacion = DATE_SUB(CURRENT_DATE,INTERVAL $intervalo DAY)";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

 $cuantos = $row['cuantos'];
 $cuantos = round($cuantos);
 echo $cuantos;
?>