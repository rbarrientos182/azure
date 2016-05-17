<?php
if (!isset($_SESSION)) 
{
	session_start();
}
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$nGrupo = $_POST['nGrupo'];
$nEmpleado = $_POST['nEmpleado'];

/** Validamos si ese numero de supervision ya existe en la idoperacion **/
$consulta = "SELECT COUNT(numgrupo) AS cuantos FROM gruposupervision WHERE idoperacion = $idoperacion AND numgrupo = $nGrupo";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);


/** Si el query dio 0 no hay ese numgrupo en esa idoperacion y se procede a agregarla**/
if ($row['cuantos']==0) {

	$consulta = "INSERT INTO gruposupervision (idoperacion,numgrupo,NumEmpleado) 
			 VALUES ($idoperacion,$nGrupo,'$nEmpleado')";
	$db->consulta($consulta);

	$consulta = "UPDATE UsrCambios SET asignado = 1 WHERE NumEmpleado = $nEmpleado";
	$db->consulta($consulta);
}

header('Location: GSupervision.php');
?>