<?php 
if (!isset($_SESSION)) 
{
	session_start();
}

include_once('clases/class.MySQL.php');
$db = new MySQL();

$nud = $_POST['idN'];
$idP = $_POST['idP'];
$idM = $_POST['idM'];
$fechaO = $_POST['fechaO'];
$idop = $_SESSION['idoperacion'];
$nivel = $_SESSION['nivel'];
$ppp = $_SESSION['ppp'];
$condicion = NULL;

//comprabamos si el usuario de la sesion es promotor, si la condicion es verdadera filtramos clientes por su PPP
if($nivel==2){
	$condicion = "AND c.ppp = ".$ppp;
}

//consultados al cliente en base a la operacion del deposito relacionada con el cliente y a la fecha de orden
$consulta = "SELECT COUNT(nombre) AS cuantos  FROM Clientes C INNER JOIN Operaciones O ON C.iddeposito = O.iddeposito AND  C.nud = $nud AND O.idoperacion = $idop ".$condicion." LIMIT 1";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

$res = 0;

//preguntamos si el usuario existe en caso de que si volvemos a realizar una 
//segunda validacion para saber si ya existe en captura cambios
if($row['cuantos']>0){
	
		$res = 1;
}
echo $res;
?>