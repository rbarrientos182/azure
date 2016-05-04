<?php 
if (!isset($_SESSION)) 
{
	session_start();
}
require_once('clases/class.MySQL.php');
$db = new MySQL();

$usuario = $_POST['username'];
$clave = $_POST['password'];

$clave = md5($clave);

$consulta = "SELECT idoperacion, ppp, NumEmpleado, nivel, Psw, COUNT(NumEmpleado) AS cuantos FROM UsrCambios  WHERE  NumEmpleado = $usuario AND Psw = '$clave' LIMIT 1";
$result = $db->consulta($consulta);
$row = $db->fetch_assoc($result);


//preguntamos si el usuario solo tiene un deposito
if($row['cuantos']==1)
{

	$_SESSION['NumEmpleado'] = $row['NumEmpleado'];
	$_SESSION['nivel'] = $row['nivel'];
	$_SESSION['idoperacion'] = $row['idoperacion'];
	$_SESSION['ppp'] = $row['ppp'];



	if(md5($row['NumEmpleado'])!=$row['Psw']){
		header("Location: index.php");
	}
	else{

		header("Location: cambioPsw.php");
	}
    
}

//si tiene mas de 1 un deposito asignado ponemos 
elseif($row['cuantos']>1) {
	$_SESSION['NumEmpleado'] = $row['NumEmpleado'];
	$_SESSION['nivel'] = $row['nivel'];
	$_SESSION['ppp'] = $row['ppp'];
	header("Location: loginDepositos.php");
}


//si no significa que el usuario no existe y se vuelve a solicitar su usuario y contraseña
else{

	header ("Location: login.php");

}
?>