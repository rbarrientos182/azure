<?php
if (!isset($_SESSION)) 
{
	session_start();
}
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$nGrupo = $_POST['nGrupo']; //valor que esta como readonly
$nEmpleado = $_POST['nEmpleado'];//valor del select
$numEmp = $_POST['numEmp'];//valor de hidden para saber que numemp traia
$idgruposupervision = $_POST['idgruposup'];//valor del pk del registro a modificar

/** Si el query dio 0 no hay ese numgrupo en esa idoperacion y se procede a agregarla**/
if ($nEmpleado!=$numEmp) {

	//actualizamos al usuario que previamente tenia asignado este grupo a disponible
	$consulta = "UPDATE UsrCambios SET asignado = 0 WHERE NumEmpleado = $numEmp";
	$db->consulta($consulta);

	//actualizamos el registro con el nuevo supervisor
	$consulta = "UPDATE gruposupervision SET NumEmpleado = $nEmpleado WHERE idgruposupervision = $idgruposupervision";
	$db->consulta($consulta);

	//actualizamos al nuevo supervisor como asignado
	$consulta = "UPDATE UsrCambios SET asignado = 1 WHERE NumEmpleado = $nEmpleado";
	$db->consulta($consulta);

}

header('Location: GSupervision.php');
?>