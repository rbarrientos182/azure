<?php 

require_once("clases/class.MySQL.php");
$mysqli = new MySQL();

$limit = $_POST['limit'];

$consulta = "SELECT idoperacion AS cuantos FROM orden WHERE fecha > CURRENT_DATE GROUP BY idoperacion";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

 $cuantos = $row['cuantos'];
 $cuantos = round($cuantos);
 echo $cuantos;
?>