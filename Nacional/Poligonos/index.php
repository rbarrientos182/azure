<?php
date_default_timezone_set('America/Mexico_City');

require_once('clases/class.MySQL.php');
$db = new MySQL ();


//Query para obtener los Depositos se ordenan alfabeticamente
$consulta = "SELECT idDeposito, deposito FROM Deposito ORDER BY deposito";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

// Query para obtener las rutas del primer Deposito ordenado en el primer Query
$consultaRutas = "SELECT idRuta FROM Ruta r INNER JOIN Operaciones o ON r.idoperacion = o.idoperacion WHERE o.idDeposito = ".$row['idDeposito'];
$resultadoRutas = $db->consulta($consultaRutas);
$rowRutas = $db->fetch_assoc($resultadoRutas);
?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen and (min-width: 535px)" />
		<link rel="stylesheet" type="text/css" href="css/mobile.css" media="screen and (max-width:535px)"/>
		<!--<link rel="stylesheet" type="text/css" href="css/style.css">-->
		<!-- CSS de Bootstrap -->
   		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
   		<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
   		
		<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
		<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
		<!-- The fav icon -->
		<script>
			// JavaScript Document
			$(document).ready(
				function ()
				{
					// botón click consultar para mostrar el mapa
					$("#bConsultar").click(function(){

						//alert('hizo click');
						var id = $("#idD").val();
						var Hem = $("#Hem").val();
						var idR = $("#idR").val();

						//alert("idDeposito es "+id+" hemisferio es "+Hem+" ruta es "+idR);
						$('#div1').html("<iframe src='mapasDeposito.php?id="+id+"&Hem="+Hem+"&idR="+idR+"' frameborder='0'></iframe>");


					});// Fin de bConsultar

					// Select Depósito cuando a otro
					$("#idD").change(function(){
						
						//obtiene valor del idDeposito
						var id = $(this).val();

						//alert("El No. de CEDIS es "+id);

						// se carga via ajax el select de ruta por medio de JSON
						$.ajax({
							  type:'POST',
							  url:"jsonRuta.php",
							  data:"id="+id,
							  async: true,
							  dataType: "json",
							  success:function(datos){
								  // vaciamos primero el select de ruta
								  $("#idR").empty();	
								  var dataJson = eval(datos);
								  $("#idR").append('<option value="0">Todas</option>');
								  for(var i in dataJson){
									  //alert(dataJson[i].idRuta);
									  $("#idR").append('<option value="'+dataJson[i].idRuta+'">'+dataJson[i].idRuta+'</option>');  
								  }
							  },
							  error:function(obj, error, objError){
								  alert("error "+error);
								  console.log(error);
							  }
						 });// fin de ajax
					});// fin de idD
				}
			);		
		</script>
		<link rel="shortcut icon" href="img/logo.ico">
	</head>
	<body>
		<div id="div2" class="div col-sm-10">
			<form class="form-horizontal">
				<div class="form-group">
					<label for="inputDeposito">Depósito</label>
					<select class="form-control input-sm" id="idD">
						<?php do{?>
							<option value="<?php echo $row['idDeposito'];?>"><?php echo $row['deposito'];?></option>
						<?php }while($row = $db->fetch_assoc($resultado));?>
					</select>
				</div>
				<div class="form-group">
					<label for="inputHemisferio">Hemisferio</label>
					<select class="form-control input-sm" id="Hem">
						<option value="0">Todos</option>
						<option value="1">LRV</option>
						<option value="2">MJS</option>
					</select>
				</div>
				<div class="form-group">
					<label for="inputRuta">Rutas</label>
					<select class="form-control input-sm" id="idR">
						<option value="0">Todas</option>
						<?php do{?>
							<option value="<?php echo $rowRutas['idRuta'];?>"><?php echo $rowRutas['idRuta'];?></option>	
						<?php }while($rowRutas = $db->fetch_assoc($resultadoRutas));?>
					</select>
				</div>
				<div class="form-group">
					<button type="button" id="bConsultar" name="b_Consultar" class="btn btn-primary">Consultar</button>
				</div>
			</form>
		</div>
		<div id="div1" class="div">	
			 		
		</div>
	</body>
</html>