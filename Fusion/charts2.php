<?php
$iddeposito = $_GET['iddeposito'];
date_default_timezone_set('America/Mexico_City');
// Desactivar toda notificación de error
error_reporting(0);


if(date("H:i:s") >= 15){

header('Location: ../Depositos/tablaRutasVPP.php?iddeposito='.$iddeposito);


}

?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
		<link rel="stylesheet" type="text/css" href="css/stylecharts.css">
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
					var iddeposito = <?php echo $iddeposito; ?>;
					//alert(iddeposito);
					
					$('#div2').html("<iframe src='chart_EfectividadDeVisita1.php?iddeposito="+iddeposito+"' frameborder='0'></iframe>");
					$('#div3').html("<iframe src='chart_EntregaClientes1.php?iddeposito="+iddeposito+"' frameborder='0'></iframe>");
					//$('#div4').html("<iframe src='chart_EfectividadEntregaCajas1.php?iddeposito="+iddeposito+"' frameborder='0'></iframe>");
					$('#div5').html("<iframe src='chart_kmreal_kmteorico2.php?iddeposito="+iddeposito+"' frameborder='0'></iframe>");
					$('#div6').html("<iframe src='tiemposPM.php?iddeposito="+iddeposito+"' frameborder='0'></iframe>");
							
					setTimeout(function(){
						//alert('entro a redireccionar');
			    		/*$(location).attr('href','imagen.php?iddeposito='+iddeposito);
					},60000);*/
					$(location).attr('href','tablaRutasVPP.php?iddeposito='+<?php echo $iddeposito?>);
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

		<!--<div id="div4" class="div">

		</div>--> 

	</div>	
	<div id="contenedor2">	
		<div id="div5" class="div">

		</div>
	</div>	
	<div id="contenedor3">	
		<div id="div6" class="div">

		</div>
	</div>	
	</body>
</html>