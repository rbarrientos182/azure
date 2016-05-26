<?php
// Desactivar toda notificación de error
error_reporting(0);

header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

$idoperacion = $_GET['idoperacion'];

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$iddeposito = $_GET['iddeposito'];

$consulta = "SELECT
idRuta, 
firmaElectroncia,
salidaCedis,
ADDTIME(salidaCedis, traslado1Cliente) AS primer_cliente,
traslado1Cliente,
tiempoServicio,
tiempoTraslado,
trasladoUltimoCliente,
llegadaCedis,
tiempoCedis FROM resumen_ruta 
WHERE fechaOperacion = CURRENT_DATE AND iddeposito = $iddeposito AND tipoRuta = 6";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

do{
	$arrayFe = split(':', $row['firmaElectroncia']);
	$arraySc = split(':', $row['salidaCedis']);
	$arrayPc = split(':', $row['primer_cliente']);
	$cadena .= "['".$row['idRuta']."',"."'Tiempo en Cedis AM', new Date(0,0,0,".$arrayFe[0].",".$arrayFe[1].",".$arrayFe[2]."), new Date(0,0,0,".$arraySc[0].",".$arraySc[1].",".$arraySc[2].")],"."['".$row['idRuta']."',"."'Traslado 1er Cliente', new Date(0,0,0,".$arraySc[0].",".$arraySc[1].",".$arraySc[2]."), new Date(0,0,0,".$arrayPc[0].",".$arrayPc[1].",".$arrayPc[2].")],";

}while($row = $resultado->fetch_assoc());

$cadena = substr($cadena, 0, -1);
?>
<!DOCTYPE HTML>
<html>
	<head lang="es">
		<meta>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>
			Gepp
		</title>
		<style type="text/css">
			
			#div_charline{

				border-radius: 10px;
				background: #FFFFFF;
				margin-left:0.25%;
				margin-right: 0.25%;
				position: absolute;
				top:0;
				left:0;
				right:0;
				bottom:0;
				margin: auto;
			}

		</style>
        <script type="text/javascript" src="js/jquery.flot.min.js"></script>
        <script type="text/javascript" src="js/jquery.flot.pie.min.js"></script>
        <script type="text/javascript" src="js/jquery.flot.resize.js"></script>
        <script type="text/javascript" src="js/jquery.flot.pie.stack.js"></script>
	</head>
	<body>
		<div id="chart_div" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">	
			 		
		</div>
	</body>
</html>