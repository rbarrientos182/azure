<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();
$noemp = $_POST['noemp'];
//$usuario = $_POST['usuario'];

$pass = md5($_POST['pass']);

$consulta = "UPDATE usrcambios SET Psw = '$pass' WHERE NumEmpleado = $noemp";
$db->consulta($consulta);

header('Location: index.php')
?>