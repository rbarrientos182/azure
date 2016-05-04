<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idUsuarios = $_POST['idUsuarios'];
$usuario = $_POST['usuario'];
$pass = md5($_POST['pass']);
$nombre = $_POST['nombre'];
$puesto = $_POST['puesto'];
$email = $_POST['email'];
$tel = $_POST['tel'];

$consulta = "UPDATE usuarios SET  clave = '$pass', nombre = '$nombre', puesto = '$puesto', 
			correo = '$email', telefono = '$tel' WHERE idUsuarios = $idUsuarios";
$db->consulta($consulta);

header('Location: usuarios.php')

?>