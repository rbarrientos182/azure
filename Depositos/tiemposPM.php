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
(TIME_TO_SEC(tiempoCedis)/60)/60 AS tiempoCedisPm,
(TIME_TO_SEC(trasladoUltimoCliente)/60)/60 AS trasladoUltimoCliente,
(TIME_TO_SEC(llegadaCedis)/60)/60 AS llegadaCedis
FROM resumen_ruta 
WHERE fechaOperacion = CURRENT_DATE AND iddeposito = $iddeposito AND tipoRuta = 6 ORDER BY tiempoCedis";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

do{

	/** Tiempo en Mercado **/
	$cadenaTm .= round($row['llegadaCedis'],2).','; 
	$cadenatUc .= round($row['trasladoUltimoCliente'],2).',';
	$cadenaPm .= round($row['tiempoCedisPm'],2).',';
	$cadenaRutas .= "'".$row['idRuta']."',";
	$cadena20 .= 18.00.',';
}while($row = $resultado->fetch_assoc());

	$cadenaRutas = substr($cadenaRutas, 0, -1);
	$cadenaTm = substr($cadenaTm, 0,-1);
	$cadenatUc = substr($cadenatUc, 0,-1);
	$cadenapPm = substr($cadenapPm, 0,-1);
	$cadena20 = substr($cadena20, 0,-1);
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
		            text: 'Tiempos PM'
		        },
		        xAxis: {
		            categories: [<?php echo $cadenaRutas;?>]
		        },
		        yAxis: {
		            min: 15,
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
			      name: 'Tiempo en Cedis PM ',
			      data: [<?php echo $cadenaPm;?>],
			      color: '#1A92F4'
			     
			        }, {
			      name: 'Traslado Ultimo Cliente',
			      data: [<?php echo $cadenatUc;?>],
			      color: '#5BD557'
			        },{
			      name: 'Tiempo en Mercado',
			      data: [<?php echo $cadenaTm;?>],
			       color: '#FFFFFF'
			        },{
			      type:'spline',
			      name: 'Llegada Optima',
			      data: [<?php echo $cadena20;?>],
			      color: '#AE0303'
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