<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

$dMercado = $_POST['dMercado'];
$ruta = $_POST['ruta'];
$idUnidades = $_POST['idUnidades'];
$zona = $_POST['zona'];
$marca = $_POST['marca'];
$nEconomico = $_POST['nEconomico'];
$odometro = $_POST['odometro'];
$estatusr = $_POST['estatusr'];

$consulta = "INSERT INTO Ruta (idRuta,idoperacion,idUnidades,Marca,Zona,NumeroEconomico,Odometro,estatus) VALUES ($ruta,$dMercado,$idUnidades,'$marca','$zona',$nEconomico,$odometro,$estatusr)";
$db->consulta($consulta);

header('Location: rutas.php');
?>