<?php 
$iddeposito = $_GET['iddeposito'];
?>

<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
		<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
		<script type="text/javascript">
			setTimeout(function(){
						//alert('entro a redireccionar');
			    		$(location).attr('href','mapasDeposito.php?iddeposito='+<?php echo $iddeposito?>);
					},30000);
		</script>
		<!-- The fav icon -->
		<link rel="shortcut icon" href="img/logo.ico">
	</head>
	<body>
		<center>
			<!--<img src="img/<?php echo $iddeposito?>.png">-->
			<img src="img/TematicoTicoman.png">
		</center>
	</body>
</html>