<?php 
if (!isset($_SESSION)) 
{
	session_start();
}
require_once('clases/class.MySQL.php');
$db = new MySQL();

$idDeposito = $_POST['idDeposito'];

$_SESSION['idDeposito'] = $idDeposito;
echo 1;
	   
	  