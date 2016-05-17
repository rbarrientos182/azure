<?php 

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$limit = $_POST['limit'];

$consulta = "SELECT count(iddeposito) AS cuantos FROM Deposito  ORDER BY cuantos DESC";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);


 $cuantos = $row['cuantos'];
 $cuantos = round($cuantos);
 echo $cuantos;
?>