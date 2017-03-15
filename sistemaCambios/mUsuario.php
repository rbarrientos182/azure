<?php
if (!isset($_SESSION))
{
	session_start();
}
require_once('clases/class.MySQL.php');

$db = new MySQL();


$idoperacion = $_SESSION['idoperacion'];
$noemp = $_POST['noemp'];
$nombre = $_POST['nombre'];
//$usuario = $_POST['usuario'];

$pass = $_POST['pass'];
$ppp = $_POST['ppp'];
$nivel = $_POST['nivel'];

//comprobamos si la contraseña es la misma
$consultaUsr = "SELECT COUNT(NumEmpleado) AS cuantos FROM usrcambios WHERE NumEmpleado = $noemp AND Psw = '$pass' AND idoperacion = $idoperacion";
$resultadoUsr = $db->consulta($consultaUsr);
$rowUsr = $db->fetch_assoc($resultadoUsr);

//si cuantos es 0 significa que la contraseña no es la misma y se procede a guardar
if($rowUsr['cuantos']==0)
{
	$password = md5($pass);

	$consulta = "UPDATE usrcambios SET  Nombre = '$nombre', Psw = '$password ', PPP = $ppp,
				nivel = $nivel  WHERE NumEmpleado = $noemp AND idoperacion = $idoperacion";
	$db->consulta($consulta);
}
//si es 1 significa que la contraseña es la misma entonces no se procede a guardar y se guardar unicamente nombre y ppp
else {
	$consulta = "UPDATE usrcambios SET  Nombre = '$nombre', PPP = $ppp,
				nivel = $nivel  WHERE NumEmpleado = $noemp AND idoperacion = $idoperacion";
	$db->consulta($consulta);
}
header('Location: usuarios.php')
?>
