<?php 
if (!isset($_SESSION)) 
{
	session_start();
}
require_once('clases/class.MySQL.php');
$db = new MySQL();

$usuario = $_POST['username'];
$clave = $_POST['password'];

$clave = md5($clave);

$consulta = "SELECT idUsuarios, usuario FROM Usuarios  WHERE  usuario = '$usuario' AND clave = '$clave' AND estatus = 1";
$result = $db->consulta($consulta);
$row = $db->fetch_assoc($result);
$numRow = $db->num_rows($result);

$respuesta = 0;

if($numRow>0)
{
	// comprobamos si el usuario existente tiene asignado algún deposito 
	$consulta2 = "SELECT COUNT(idUsuarios) AS numUser FROM Permisos WHERE idUsuarios = ".$row['idUsuarios'];
	$result2 = $db->consulta($consulta2);
	$row2 = $db->fetch_assoc($result2);

	if($row2['numUser']>0)
	{
 		
	    $_SESSION['idUsuarios'] = $row['idUsuarios'];
	    header("Location: index.php");
	}

	else
	{
		header("Location: login.php");
	}

}
?>