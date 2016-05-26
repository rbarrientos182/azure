<?php 
$idoperacion = $_GET['idoperacion'];
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
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var limit = 13; // variable limite para la paginacion
			var idoperacion = <?php echo $idoperacion; ?>;
			$(document).ready(
				function ()
				{
					//alert(idoperacion);

					$.ajax({
						url:"obtenerRegistroRutas.php",
						data:'idoperacion='+idoperacion,
						type:'POST',
						cache:false,
						success:function function_name (nRegistro) {
							//alert(nRegistro);
							paginarTabla2(nRegistro,0,limit,idoperacion);
							

						},
						error: function function_name (request,error) {
							console.log("Pasó lo siguiente: "+error);
			            	//alert("Pasó lo siguiente: "+error);
						},
					});

					setTimeout(function(){
						//alert('entro a redireccionar');
			    		$(location).attr('href','charts.php?idoperacion='+idoperacion);
					},120000);
				}
			);

			function paginarTabla2(cuantos,inicio,fin,idoperacion) 
			{
				//alert('cuantos '+cuantos+' inicio '+inicio+' fin '+fin+' idoperacion'+idoperacion);

				if(inicio>=cuantos){

					inicio = 0;
					fin = 0;
						
					fin = limit;
				}

				$("#div1").load("rutas.php",{inicio:inicio, fin:limit, idoperacion:idoperacion}, function(response, status, xhr) {
				    if(status == "error") {
				            var msg = "Error!, algo ha sucedido: ";
				            $("#div1").html(msg + xhr.status + " " + xhr.statusText);
				        }
				        else if(status == "success"){
				        	inicio = fin;
							fin = fin+limit;
				    		setTimeout(function(){
							paginarTabla2(cuantos,inicio,fin,idoperacion);
							},30000);
				        }
			    });	
			}
		</script>

		<!-- The fav icon -->
		<link rel="shortcut icon" href="img/logo.ico">
	</head>
	<body>
		<a href="../dd_nacional/tablaClientes.php" class="btn btn-default btn-xs">Regresar</a>
		<div id="div1" class="div">	
			 		
		</div>
	</body>
</html>