<?php
date_default_timezone_set('America/Mexico_City');
// Desactivar toda notificación de error
error_reporting(0);

if(date("H:i:s") > 13){
	header('Location: ../Depositos/tablaRutasVPP.php?iddeposito='.$iddeposito);
}

require_once("clases/class.MySQL.php");
require_once("clases/class.Utilidades.php");

$mysqli = new MySQL();
$uti = new Utilidades();

$intervalo = $uti->obtenerIntervalo();

$iddeposito = $_GET['iddeposito'];

$consulta = "SELECT deposito FROM deposito WHERE iddeposito = $iddeposito LIMIT 1";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<!-- CSS de Bootstrap -->
   		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
   		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
   		
		<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
		<script type="text/javascript" src="js/rainbow-custom.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var iddeposito = <?php echo $iddeposito; ?>;
			$(document).ready(
				function ()
				{
					//alert(iddeposito);

					$("#div1").load("grupoSupervisor.php",{iddeposito:iddeposito}, function(response, status, xhr) {
				    if(status == "error") {
				            var msg = "Error!, algo ha sucedido: ";
				            $("#div1").html(msg + xhr.status + " " + xhr.statusText);
				        }
				        else if(status == "success"){
				        	mostrarDiv();
				        	inicio = fin;
							fin = fin+limit;
				    		setTimeout(function(){
							paginarTabla2(cuantos,inicio,fin,iddeposito);
							},30000);
				        }
			    	});

					setTimeout(function(){
						//alert('entro a redireccionar');
			    		$(location).attr('href','charts.php?iddeposito='+iddeposito);
					},120000);
				}
			);

			function mostrarDiv (){
				//alert('entro a mostrarDiv');
				$( "#div1" ).show( "blind", "slow" ); 
            }
		</script>

		<!-- The fav icon -->
		<link rel="shortcut icon" href="img/logo.ico">
	</head>
	<body>
		<!--<a href="../pantalla_aeropuerto/tablavpp.php" class="btn btn-default btn-xs">Regresar</a>-->
		<div id="div2"> 

			<CENTER> DEPOSITO  <br> 
			<b><?php echo $row['deposito']; ?></b> <br><br>
			TIPO RUTA <br>
			<b>ENTREGA </b> <br><br>
			<b>FECHA</b> <br>
            <?php 
            	$fecha = date("Y-m-d");
				$nuevafecha = strtotime ("-$intervalo day", strtotime($fecha));
				$nuevafecha = date ("Y-m-d",$nuevafecha);
				echo $nuevafecha;
            ?>
			</CENTER> 

			<div class="burbujas">
		        <img class="cuadrado" style="margin-left: 35%; margin-top: 100%; max-width: 100%" src="img/burbuja1.png" alt="Burbuja">
				<img class="cuadrado" style="animation-delay:2s; -moz-animation-delay:2s; -webkit-animation-delay:2s; margin-left: 5%; margin-top:80%, max-width: 100%" src="img/burbuja2.png" alt="Burbuja">
			</div>

		</div>

		<div id="div1">	
			 		
		</div>
	</body>
</html>