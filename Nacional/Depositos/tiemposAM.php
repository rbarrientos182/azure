<?php
// Desactivar toda notificación de error
error_reporting(0);

header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$iddeposito = $_GET['iddeposito'];

$consulta = "SELECT
idRuta,
(TIME_TO_SEC(firmaElectroncia)/60)/60 AS firmaElectronica,
(TIME_TO_SEC(traslado1Cliente)/60)/60 AS tralado1cliente,
((TIME_TO_SEC(salidaCedis) - TIME_TO_SEC(firmaElectroncia))/60)/60 AS tiempoam
FROM resumen_ruta 
WHERE fechaOperacion = CURRENT_DATE AND iddeposito = $iddeposito AND tipoRuta = 6 ORDER BY firmaElectroncia";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

do{
	//echo $row['firmaElectroncia'].',';
	
	$cadenatAM .= round($row['tiempoam'],2).',';
	$cadenapCl .= round($row['tralado1cliente'],2).',';
	$cadenaFE .= round($row['firmaElectronica'],2).',';
	$cadenaRutas .= "'".$row['idRuta']."',";
	$cadena7 .= 7.75.',';

}while($row = $resultado->fetch_assoc());

$cadenaRutas = substr($cadenaRutas, 0, -1);
$cadenatAM = substr($cadenatAM, 0,-1);
$cadenapCl = substr($cadenapCl, 0,-1);
$cadenaFE = substr($cadenaFE, 0,-1);
$cadena7 = substr($cadena7, 0,-1);
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
|
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
		<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
        <script src="js/highcharts.js"></script>
        <script src="js/highcharts-more.js"></script>
		<script type="text/javascript">
		$(function () {
		    $('#chart_div').highcharts({
		        chart: {
		            type: 'bar'
		        },
		        title: {
		            text: 'Tiempos AM'
		        },
		        xAxis: {
		            categories: [<?php echo $cadenaRutas;?>]
		        },
		        yAxis: {
		            min: 6,
                    minTickInterval: 1,
		            title: {
		                text: 'Hr (Formato 24 hrs)'
		            }
		        },
		        legend: {
		            reversed: true
		        },
		        plotOptions: {
		            series: {
		                stacking: 'normal'
		            }
		        },
		        series: [{
			      name: 'Traslado 1er Cliente ',
			      data: [<?php echo $cadenapCl;?>],
			      color: '#1A92F4' //AZUL
			     
			        }, {
			      name: 'Tiempo en Cedis AM',
			      data: [<?php echo $cadenatAM;?>],
                   color: '#5BD557', //VERDE 
			        },{
			      name: 'Firma Electronica',
			      data: [<?php echo $cadenaFE;?>],
			       color: '#FFFFFF'
			        },{
			      type:'spline',
			      name: 'Salida Optima',
			      data: [<?php echo $cadena7;?>],
			      color: '#AE0303' //ROJO
			        }]
		    });
});
		</script>
	</head>
	<body>
		<div id="chart_div" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">	
			 		
		</div>
	</body>
</html>


			        