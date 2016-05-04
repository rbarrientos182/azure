<?php
// Desactivar toda notificación de error
error_reporting(0);

header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();


$iddeposito = $_GET['iddeposito'];

$consulta = "SELECT FORMAT(AVG((clientesvp/clientesProg) * 100),1) AS Efectividad_Visita
FROM resumen_ruta WHERE iddeposito=$iddeposito AND fechaOperacion=CURRENT_DATE AND tiporuta=6
GROUP BY iddeposito";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

if ($row['Efectividad_Visita']=='') {
  $row['Efectividad_Visita']=0;
}

$valor=0;

if ($row['Efectividad_Visita']<100){
   
   $valor=100-$row['Efectividad_Visita'];
}

?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Circles</title>
  <style>
    #canvas .circle {
      display: inline-block;
      margin: 1em;
    }

    .circles-decimals {
      font-size: .4em;
    }
  </style>
</head>
<body>
  <div id="canvas">
    <div class="circle" id="circles-1"></div>


  </div>

  <script src="js/circles.min.js"></script>
  <script>
    //@ http://jsfromhell.com/array/shuffle [v1.0]
    function shuffle(o){ //v1.0
      for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
      return o;
    }

    var colors = [
      ['#D3B6C6', '#4B253A']
    ], circles = [];

    for (var i = 1; i <= 1; i++) {
      var child = document.getElementById('circles-' + i),
        percentage = 31.42 + (i * 9.84);

      circles.push(Circles.create({
        id:         child.id,
        value:    percentage,
        radius:     60,
        width:      10,
        colors:     colors[i - 1]
      }));
    }


  </script>
</body>
</html>