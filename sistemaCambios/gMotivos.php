<?php
if (!isset($_SESSION)) 
{
	session_start();
}
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$des = $_POST['des'];


$consulta = "INSERT INTO CambiosMotivos(idoperacion,Descripcion) 
			 VALUES ($idoperacion,'$des')";
$db->consulta($consulta);

header('Location: motivos.php');
?>