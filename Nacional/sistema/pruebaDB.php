<?php 
require_once('clases/class.MySQL.php');


$db = new MySQL();

$consulta = "SELECT * FROM Usuarios";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

do{
	echo $row['idUsuarios'];

}while($row = $db->fetch_assoc($resultado));

?>