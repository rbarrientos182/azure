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
$pass = md5($noemp);
$ppp = $_POST['ppp'];
$nivel = $_POST['nivel'];


$consulta2 = "SELECT COUNT(NumEmpleado) AS cuantos FROM usrcambios WHERE NumEmpleado = $noemp";
$resultado = $db->consulta($consulta2);
$row = $db->fetch_assoc($resultado);

if($row['cuantos']==0){
	$consulta = "INSERT INTO usrcambios (idoperacion,NumEmpleado,Nombre,Psw,PPP,nivel) 
					  VALUES ($idoperacion,$noemp,'$nombre','$pass',$ppp,$nivel)";
	$db->consulta($consulta);
	header('Location: usuarios.php');
}
else{
	header('Location: faUsuarios.php');
}
?>