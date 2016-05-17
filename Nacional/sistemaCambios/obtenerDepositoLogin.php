<?php 
if (!isset($_SESSION)) 
{
	session_start();
}

if(isset($_SESSION['NumEmpleado'])){

	$_SESSION['idoperacion'] = $_POST['idop'];
	header("Location: index.php");	
}

//si no hay sesion mandar a login.php
else{

	header ("Location: login.php");

}
?>