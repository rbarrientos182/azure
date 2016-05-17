<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();


$ndeposito = $_POST['idDeposito'];
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


$consulta = "UPDATE Deposito SET  deposito = '$deposito',
								 latitud = '$latitud', longitud = '$longitud', gerenteDeposito = '$gerente',
								 jefeEntrega = '$jefe', operadorSistema = '$operador', telefonoExt = '$tel',
								 correoGD = '$cgerente', correoJE = '$cjefe', correoOP = '$coperador' WHERE iddeposito=$ndeposito";
$db->consulta($consulta);

header('Location: depositos.php')
 ?>