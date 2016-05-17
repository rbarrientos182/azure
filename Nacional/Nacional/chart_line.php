<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$consulta = "SELECT o.idoperacion,d.deposito,celda,(TIME_TO_SEC(r_informacion)/60)/60 AS ci,(TIME_TO_SEC(ADDTIME(r_informacion, c_espera))/60)/60 AS cf,(TIME_TO_SEC(f_disenio)/60)/60 AS fd FROM tiempos t 
INNER JOIN operaciones o ON t.idoperacion=o.idoperacion 
INNER JOIN deposito d ON o.idDeposito=d.idDeposito  WHERE fecha > (CURRENT_DATE) GROUP BY fecha,idoperacion,celda ORDER BY deposito";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
//echo $consulta;
do{

	$cadenaDepositos .= "'".$row['deposito']."',";
	$cadenaCi .= round($row['ci'],2).",";
	$Cf = $row['cf']-$row['ci'];
	$cadenaCf .= round($Cf,2).",";
	$Fd = $row['fd']-$row['cf'];
	$cadenaFd .= round($Fd,2).",";
}while($row = $mysqli->fetch_assoc($resultado));

$cadenaDepositos = substr($cadenaDepositos,0,-1);
$cadenaCi = substr($cadenaCi,0,-1);
$cadenaCf = substr($cadenaCf,0,-1);
$cadenaFd = substr($cadenaFd,0,-1);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>Gepp</title>
		<link rel="shortcut icon" href="img/logo.ico">
		<style type="text/css">
			
			#div11{

				/*width: 100%;
				height: 100%;*/
				margin-top: 0.25%;
				margin-bottom: 0.25%;
				border: 1px solid #3399FF;
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
				setTimeout(function(){
    			$(location).attr('href','comerciales.php');
				},30000);

			    $('#div11').highcharts({
			        chart: {
			            type: 'bar'
			        },
			        title: {
			            text: 'Tiempos'
			        },
			        xAxis: {
			            categories: [<?php echo $cadenaDepositos;?>]
			        },
			        yAxis: {
			            min: 16,
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
				      name: 'Diseño',
				      data: [<?php echo $cadenaFd;?>],
				       color: '#1A92F4'
				        },{
				      name: 'Cola de Espera',
				      data: [<?php echo $cadenaCf;?>],
	                   color: '#5BD557', //VERDE 
				        },{
				      name: ' ',
				      data: [<?php echo $cadenaCi;?>],
				      color: '#FFFFFF' //AZUL
				     
				        }]
			    });
			});
		</script>
	</head>
	<body>
		<div id="div11">	
			 		
		</div>
	</body>
</html>