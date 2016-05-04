<?php 
if (!isset($_SESSION)) 
{
	session_start();
}

include_once('clases/class.MySQL.php');
$db = new MySQL();

$nud = $_POST['idN'];
$fechaP = $_POST['fechaP'];
$idop = $_SESSION['idoperacion'];
$nivel = $_SESSION['nivel'];
$ppp = $_SESSION['ppp'];


$array = array();

//comprabamos si el usuario de la sesion es promotor, si la condicion es verdadera filtramos clientes por su PPP
if($nivel==2){
	$condicion = "AND c.ppp = ".$ppp;
}



//consultados al cliente en base a la operacion del deposito relacionada con el cliente y a la fecha de orden
 $consulta = "SELECT nombre, COUNT(nombre) AS cuantos  FROM Clientes c INNER JOIN Operaciones o ON c.iddeposito = o.iddeposito AND  c.nud = $nud AND o.idoperacion = $idop ".$condicion." LIMIT 1";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

$nombre = 'El cliente no se encontro';
$estatusCambio = 0;


if($row['cuantos']>0){

	$nombre = $row['nombre'];

	//Consulto si el cliente tiene un pedido en captura cambios
	$consulta2 = "SELECT COUNT(nud) AS cuantos FROM CapturaCambios WHERE idoperacion = $idop AND nud = $nud AND FechaCambio = '$fechaP' AND estatusDis = 0 LIMIT 1";
	$resultado2 = $db->consulta($consulta2);
	$row2 = $db->fetch_assoc($resultado2);


	//preguntamos si el cliente tiene un pedido en captura cambios
	if ($row2['cuantos']>0) {
		$estatusCambio = 1;
	}
}


$array[] = array('nombre'=>$nombre,
				 'estatusCambio'=>$estatusCambio);


echo ''.json_encode($array).'';

//echo $nombre;
?>