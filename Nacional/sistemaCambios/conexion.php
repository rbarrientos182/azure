<?php

//$link = mysqli_connect("10.50.4.5:8080","gepp","gepp","gepp") or die("Error " . mysqli_error($link)); 
//$conexion = mysql_connect("10.50.4.5", "gepp", "gepp")or die("Error " . mysql_error($link));
//mysql_select_db("gepp", $conexion);


//$link = mysql_connect ($host, $user, $password) or die ("<center>No se puede conectar con la base de datos\n</center>\n");


$conexion = mysqli_connect("10.50.4.5","gepp","gepp","gepp") or die("Error " . mysqli_error($conexion));
$consulta = "SELECT * FROM UsrCambios";
$resultado = mysqli_query($conexion,$consulta);
$row = mysqli_fetch_assoc($resultado);
do{
	echo $row['Nombre'];
	echo '<br>';
}while ($row = mysqli_fetch_assoc($resultado));
?>