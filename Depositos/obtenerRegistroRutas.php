<?php 
// Desactivar toda notificación de error
error_reporting(0);

require_once("clases/class.MySQL.php");
$mysqli = new MySQL();

$iddeposito = $_POST['iddeposito'];
$tipoRuta = $_POST['tipoRuta'];

$consulta = "SELECT count(idRuta) AS cuantos FROM resumen_ruta  WHERE iddeposito = $iddeposito AND tipoRuta = $tipoRuta AND fechaOperacion = CURRENT_DATE";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

 $cuantos = $row['cuantos'];
 $cuantos = round($cuantos);
 echo $cuantos;
?>