<?php 
require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$iddeposito = $_GET['iddeposito'];

//$iddeposito = 111;

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
			var limit = 15; // variable limite para la paginacion
			var iddeposito = <?php echo $iddeposito; ?>;
			$(document).ready(
				function ()
				{
					//alert(iddeposito);

					$.ajax({
						url:"obtenerRegistroRutas.php",
						data:'iddeposito='+iddeposito+'&tipoRuta=3',
						type:'POST',
						cache:false,
						success:function function_name (nRegistro) {
							//alert(nRegistro);
							paginarTabla2(nRegistro,0,limit,iddeposito);
							

						},
						error: function function_name (request,error) {
							console.log("Pasó lo siguiente: "+error);
			            	//alert("Pasó lo siguiente: "+error);
						},
					});

					/*setTimeout(function(){
						//alert('entro a redireccionar');
			    		$(location).attr('href','charts.php?iddeposito='+iddeposito);
					},120000);*/
				}
			);

			function paginarTabla2(cuantos,inicio,fin,iddeposito) 
			{
				//alert('cuantos '+cuantos+' inicio '+inicio+' fin '+fin+' iddeposito'+iddeposito);

				if(inicio>=cuantos){

					inicio = 0;
					fin = 0;
						
					fin = limit;
				}

				$("#div1").load("rutasPPP.php",{inicio:inicio, fin:limit, iddeposito:iddeposito}, function(response, status, xhr) {
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
			}
			
			function mostrarDiv (){
				//alert('entro a mostrarDiv');
				$( "#div1" ).show( "blind", "slow" );  
            }


		</script>

		<!-- The fav icon -->
		<link rel="shortcut icon" href="img/logo.ico">
	</head>
	<body>
		<!--<a href="../pantalla_aeropuerto/index.php" class="btn btn-default btn-xs">Regresar</a>-->
        <div id="div2"> 
            <CENTER> DEPOSITO  <br> 
			<b><?php echo $row['deposito']; ?></b> <br><br>
			TIPO RUTA <br>
			<b>PREVENTA </b> </CENTER>
		</div>

		<div id="div1" >

		</div>
	</body>
</html>