<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idNivel = $_POST['idNivel'];
$usuario = $_POST['usuario'];
$pass = md5($_POST['pass']);
$nombre = $_POST['nombre'];
$puesto = $_POST['puesto'];
$email = $_POST['email'];
$tel = $_POST['tel'];

$consulta = "INSERT INTO usuarios (usuario,clave,nombre,puesto,correo,telefono,estatus) 
				  VALUES ('$usuario','$pass','$nombre','$puesto','$email','$tel',1)";
$db->consulta($consulta);

header('Location: usuarios.php');
?>