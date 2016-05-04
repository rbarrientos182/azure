<?php
// Desactivar toda notificación de error
error_reporting(0);
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

/*require_once("clases/class.MySQL.php");

$mysqli = new MySQL();*/
$mysqli = new mysqli('localhost','gepp','gepp','gepp');

$idoperacion = $_GET['idoperacion'];

$consulta = "SELECT  FORMAT(AVG(Capacidad),1) AS Capacidad FROM
(SELECT  o.idoperacion AS idoperacion, o.idruta ,  ROUND((SUM(cfisicas)*100)/capacidad,1) AS Capacidad  FROM orden o
INNER JOIN (SELECT idoperacion, idruta, capacidad FROM Ruta r INNER JOIN Unidades u ON r.idunidades=u.idunidades) a
ON o.idoperacion=a.idoperacion AND o.idruta=a.idruta AND o.idoperacion = ".$idoperacion."
WHERE fecha = CURRENT_DATE 
GROUP BY o.idoperacion, o.idruta) b";
/*$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);*/
$resultado = $mysqli->query($consulta);
$row = $resultado->fetch_assoc();
//echo $consulta;
?>
<!DOCTYPE HTML>
<html>
  <head>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['gauge']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['% Carga', <?php echo $row['Capacidad']; ?>],
        ]);

        var options = {
          width: '100%', height: '100%',
          chartArea: {top:"50%",width:"100%",height:"100%"},
          redFrom: 95, redTo: 100,
          yellowFrom:80, yellowTo: 95,
          greenFrom:60, greenTo: 80,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
        chart.draw(data, options);
         function resizeHandler () {
            chart.draw(data, options);
          }
          if(window.addEventListener){
              window.addEventListener('resize', resizeHandler, false);
          }
          else if(window.attachEvent){
            window.attachEvent('onresize', resizeHandler);
          }
      }
    </script>
  </head>
  <body>
    <center>
      <div class="divGrafica" id='chart_div' style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;"></div>
      <?php $mysqli->liberar($resultado);;?>
    </center>
  </body>
</html>

