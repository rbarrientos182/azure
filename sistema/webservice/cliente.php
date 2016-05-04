<?php 
require_once("nusoap/nusoap.php");

$cliente = new nusoap_client("prueba.wsdl",true);

$error = $cliente->getError();


if ($error) {
	echo "<h2>Constructor Error</h2><pre>".$error."</pre>";
}

$result = $cliente->call("setOrden", array("archivo"=>"D825TC01F13012014.csv"));

if($cliente->fault){

	echo "<h2>Fault</h2><pre>";
	print_r($result);
	echo "</pre>";

}
else{

	$error = $cliente->getError();
	if ($error) {
		echo "<h2>Error</h2><pre>".$error."</pre>";
	}
	else{
		echo "<h2>Archivos</h2><pre>";
		echo $result;
		echo "</pre>";
	}
}
?>