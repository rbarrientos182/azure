<?php
require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$iddeposito = $_GET['iddeposito'];

$consulta = "SELECT d.deposito, o.idoperacion FROM deposito d INNER JOIN operaciones o ON d.idDeposito = o.idDeposito WHERE d.idDeposito = $iddeposito AND o.mercado = 0 LIMIT 1";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

$idoperacion = $row['idoperacion'];	
?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
		<link rel="stylesheet" type="text/css" href="css/stylecharts2.css">
		<!-- CSS de Bootstrap -->
   		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
   		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
   		
		<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
		<script type="text/javascript" src="js/rainbow-custom.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(
				function ()
				{
					var idoperacion = <?php echo $idoperacion; ?>;
					//alert(idoperacion);
					
					$('#div2').html("<iframe src='gauge_chart.php?idoperacion="+idoperacion+"' frameborder='0'></iframe>");
					$('#div3').html("<iframe src='donnut_chart.php?idoperacion="+idoperacion+"' frameborder='0'></iframe>");
					$('#div4').html("<iframe src='donnut_chartECompra.php?idoperacion="+idoperacion+"' frameborder='0'></iframe>");
					$('#div5').html("<iframe src='pie_chart.php?idoperacion="+idoperacion+"' frameborder='0'></iframe>");
					$('#div6').html("<iframe src='combo_chart.php?idoperacion="+idoperacion+"' frameborder='0'></iframe>");
							
					setTimeout(function(){
						//alert('entro a redireccionar');
						$(location).attr('href','tablaRutasVPP.php?iddeposito='+<?php echo $iddeposito;?>);
			    		//$(location).attr('href','comerciales.php?iddeposito='+<?php echo $iddeposito;?>);
					},60000);

				}
			);
		</script>

		<!-- The fav icon -->
		<link rel="shortcut icon" href="img/logo.ico">
	</head>
	<body>
	<div id="contenedor1">
		<div id="div2" class="div">
			
		</div>

		<div id="div3" class="div">

		</div>

		<div id="div4" class="div">

		</div>

		<div id="div5" class="div">

		</div>
	</div>	
	<div id="contenedor2">	
		<div id="div6" class="div">

		</div>
	</div>	
	</body>
</html>