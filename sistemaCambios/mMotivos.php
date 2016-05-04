<?php
if (!isset($_SESSION)) 
{
	session_start();
}
require_once('clases/class.MySQL.php');

$db = new MySQL();

$id = $_POST['id'];
$Descripcion = $_POST['Des'];


$consulta = "UPDATE CambiosMotivos SET Descripcion='$Descripcion' WHERE idCambiosMotivos=$id";
$db->consulta($consulta);

header('Location: motivos.php');
?>