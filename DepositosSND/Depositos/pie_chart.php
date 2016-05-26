<!DOCTYPE HTML>
<html lang="es">
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

$idoperacion = $_GET['idoperacion'];

$consulta = "SELECT mnud, tnud FROM 
(SELECT idoperacion, COUNT(nud) AS mnud FROM orden WHERE fecha > CURRENT_DATE AND cfisicas < 2 AND idoperacion = ".$idoperacion." ) a,
(SELECT idoperacion, COUNT(nud) AS tnud FROM orden WHERE fecha > CURRENT_DATE AND idoperacion = ".$idoperacion." ) b, 
(SELECT idoperacion, deposito FROM operaciones o INNER JOIN deposito d ON o.iddeposito=d.iddeposito AND o.idoperacion = ".$idoperacion.") c
WHERE a.idoperacion=c.idoperacion";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
//echo $consulta;
?>  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="css/style_graficas.css">
    <!-- CSS de Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
          //alert('entro a function');
          var data = google.visualization.arrayToDataTable([
            ['Clientes', 'Cantidad Clientes'],
            [<?php echo $row['mnud'];?>+' Clientes < 2 cajas', <?php echo $row['mnud']; ?>],
            [<?php echo $row['tnud']-$row['mnud'];?>+' Clientes > 2 cajas', <?php echo $row['tnud']-$row['mnud']; ?>],
          ]);

          var options = {
            title: 'Clientes menor a 2 cajas',
            pieSliceText: 'percentage',
            fontSize: 12,
            chartArea: {top:"20%",width:"100%",height:"100%"},
            legend: 'top',
            //is3D: true,
            //pieHole: 0.4,
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
      <div  class="divGrafica" id="piechart_3d" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">
        
      </div>
       <?php $mysqli->liberar($resultado);?>
    </center>
  </body>
</html>