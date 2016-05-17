<?php 
require_once("clases/class.MySQL.php");
$db = new MySQL();

$id = $_POST['id'];

$consultaRutas = "SELECT idRuta FROM Ruta r INNER JOIN Operaciones o ON r.idoperacion = o.idoperacion WHERE o.idDeposito = ".$id;
$resultadoRutas = $db->consulta($consultaRutas);
$rowRutas = $db->fetch_assoc($resultadoRutas);

//se crea un array para guardar los elementos de la consulta
$arrayRutas = array();
do
{
	$arrayRutas[] = array('idRuta'=> $rowRutas['idRuta']);
}
while($rowRutas = $db->fetch_assoc($resultadoRutas));

echo ''.json_encode($arrayRutas).'';
?>