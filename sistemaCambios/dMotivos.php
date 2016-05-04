<?php
if (!isset($_SESSION)) 
{
	session_start();
}
require_once('clases/class.MySQL.php');

$db = new MySQL();

$id = $_GET['id'];



$consulta = "DELETE FROM CambiosMotivos WHERE idCambiosMotivos=$id";
$db->consulta($consulta);

header('Location: motivos.php');
?>