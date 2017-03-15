<?php
if (!isset($_SESSION))
{
	session_start();
}

require_once('clases/class.MySQL.php');

$db = new MySQL();

$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$NumEmpleado  = $_SESSION['NumEmpleado'];

if($password1 == $password2)
{
	$password1 = md5($password1);
	$consulta = "UPDATE UsrCambios SET  Psw = '$password1' WHERE NumEmpleado=$NumEmpleado";
	$db->consulta($consulta);

	$consulta2 = "SELECT
	idoperacion,
	ppp,
	NumEmpleado,
	MD5(NumEmpleado) AS NumEmp,
	nivel,
	Psw,
	COUNT(NumEmpleado) AS cuantos
	FROM
	    UsrCambios
	WHERE
	    NumEmpleado = $NumEmpleado
	        AND Psw = '$password1'
	LIMIT 1";
	$result2 = $db->consulta($consulta2);
	$row2 = $db->fetch_assoc($result2);

	if($row2['cuantos']==1)
	{

		$_SESSION['nivel'] = $row2['nivel'];
		$_SESSION['idoperacion'] = $row2['idoperacion'];
		$_SESSION['ppp'] = $row2['ppp'];
		header("Location: index.php");
	}

	//si tiene mas de 1 un deposito asignado ponemos
	elseif($row2['cuantos']>1) {
		$_SESSION['nivel'] = $row2['nivel'];
		$_SESSION['ppp'] = $row2['ppp'];
		header("Location: loginDepositos.php");
	}

}
else{

	header('Location: cambioPsw.php');

}
?>
