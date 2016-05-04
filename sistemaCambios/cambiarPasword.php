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

	header('Location: index.php');
}
else{

	header('Location: cambioPsw.php');

}
?>