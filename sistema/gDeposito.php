<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idZ = $_POST['idZ'];
$ndeposito = $_POST['ndeposito'];
$deposito = $_POST['deposito'];
$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];
$gerente = $_POST['gerente'];
$cgerente = $_POST['cgerente'];
$jefe = $_POST['jefe'];
$cjefe = $_POST['cjefe'];
$operador = $_POST['operador'];
$coperador = $_POST['coperador'];
$tel = $_POST['tel'];
$estatus = $_POST['estatusr'];


echo $consulta = "INSERT INTO Deposito (idZona,idDeposito,deposito,latitud,longitud,gerenteDeposito,jefeEntrega,operadorSistema,telefonoExt,correoGD,correoJE,correoOP,estatus) 
						   VALUES ($idZ,$ndeposito,'$deposito','$latitud','$longitud','$gerente','$jefe','$operador','$tel','$cgerente','$cjefe','$coperador',$estatus)";
$db->consulta($consulta);

header('Location: depositos.php')
 ?>