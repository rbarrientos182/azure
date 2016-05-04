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



$consulta = "SELECT COUNT(b.idoperacion),  SUM(paradastotales) AS sumparadas, SUM(confrecuencia) AS sumconfrecuencia, SUM(prog) AS programados, CONCAT(FORMAT(SUM(confrecuencia) * 100 / SUM(prog),2), '%') efectividad_compra,
CONCAT(FORMAT((SUM(paradastotales - confrecuencia)/SUM(paradastotales))*100,2),' %') AS VisitadosNoProgramados 
FROM
(SELECT o.idoperacion, ppp, COUNT(distinct o.nud) paradastotales FROM orden o
INNER JOIN operaciones op ON op.idoperacion = o.idoperacion AND op.idoperacion = ".$idoperacion."
INNER JOIN clientes c ON c.nud = o.nud AND c.iddeposito = op.iddeposito
WHERE  fecha = CURRENT_DATE GROUP BY idoperacion, ppp) a,
(SELECT o.idoperacion AS idoperacion, ppp AS idruta, count(distinct o.nud) AS confrecuencia FROM orden o
INNER JOIN operaciones op ON op.idoperacion = o.idoperacion AND op.idoperacion = ".$idoperacion." 
INNER JOIN clientes c ON o.nud=c.nud AND c.iddeposito = op.idDeposito
WHERE  fecha = CURRENT_DATE AND dia LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(CURDATE()) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%')  -- and o.idoperacion = 8
GROUP BY idoperacion,ppp) b,
(SELECT idoperacion, ppp, COUNT(nud) AS prog FROM clientes c
INNER JOIN operaciones op ON op.iddeposito = c.iddeposito AND op.idoperacion = ".$idoperacion."
WHERE dia LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(CURDATE()) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%')
GROUP BY idoperacion, ppp
) d
WHERE a.idoperacion = b.idoperacion AND a.ppp=b.idruta 
AND a.idoperacion = d.idoperacion AND a.ppp = d.ppp";
/*$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);*/
$resultado = $mysqli->query($consulta);
$row = $resultado->fetch_assoc();

//echo $consulta;
?>
<!DOCTYPE HTML>
<html lang="es">
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        //alert('entro a function');
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          [<?php echo $row['sumconfrecuencia'];?>+' Con Compra', <?php echo $row['sumconfrecuencia']; ?>],
          [<?php echo $row['programados']-$row['sumconfrecuencia'];?>+' Sin Compra', <?php echo $row['programados']-$row['sumconfrecuencia']; ?>],
        ]);

        var options = {
          chartArea: {top:"20%",width:"100%",height:"100%"},
          legend: 'top',
          title: 'Efectividad Compra',
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
    </center>
  </body>
</html>