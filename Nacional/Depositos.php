<?php 
date_default_timezone_set('America/Mexico_City');
// Desactivar toda notificación de error
error_reporting(0);

$iddeposito = $_GET['iddeposito'];
if(date("H:i:s") >= 15){
	header('Location: Depositos/tablaRutasVPP.php?iddeposito='.$iddeposito);
}
elseif(date("H:i:s") < 15){
	header('Location: Fusion/tablaRutas2.php?iddeposito='.$iddeposito);
}
?>