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

$consulta = "SELECT SUM(a.idruta) AS Total, IF(ISNULL(SUM(b.idruta)),0,SUM(b.idruta)) AS Programado, (SUM(a.idruta)-IF(ISNULL(SUM(b.idruta)),0,SUM(b.idruta)) ) AS optimizado FROM 
(SELECT COUNT(idruta) AS idruta, idoperacion FROM ruta WHERE idoperacion = ".$idoperacion." GROUP BY idoperacion) a
LEFT JOIN (SELECT COUNT(distinct idruta) AS idruta, idoperacion FROM orden WHERE fecha = CURRENT_DATE AND idoperacion = ".$idoperacion." GROUP BY idoperacion) b
ON a.idoperacion=b.idoperacion";
/*$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);*/
$resultado = $mysqli->query($consulta);
$row = $resultado->fetch_assoc();

//echo $consulta;
?>
<!DOCTYPE HTML>
<html lang="es">
  <head>
    <link rel="stylesheet" type="text/css" href="css/style_graficas.css">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        //alert('entro a function');
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          [<?php echo $row['Programado'];?>+' Programados', <?php echo $row['Programado']; ?>],
            [<?php echo $row['optimizado'];?>+' Sin Programar', <?php echo $row['optimizado']; ?>],
        ]);

        var options = {
          chartArea: {top:"20%",width:"100%",height:"100%"},
          legend: 'top',
          title: 'Rutas',
          //is3D: true,
          pieHole: 0.4,
          slices: {
            0: { color: 'blue' },
            1: { color: '#3399FF' }
          }

        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
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
      <div class="divGrafica" id="piechart_3d" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">
      </div>
       <?php $mysqli->liberar($resultado);?>
    </center>
  </body>
</html>