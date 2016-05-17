<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();

$noemp = $_POST['noemp'];
$nombre = $_POST['nombre'];
//$usuario = $_POST['usuario'];

$pass = md5($_POST['pass']);
$ppp = $_POST['ppp'];
$nivel = $_POST['nivel'];

$consulta = "UPDATE usrcambios SET  Nombre = '$nombre', Psw = '$pass', PPP = $ppp, 
			nivel = $nivel  WHERE NumEmpleado = $noemp";
$db->consulta($consulta);

header('Location: usuarios.php')
?>