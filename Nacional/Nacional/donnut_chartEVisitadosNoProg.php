<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$consulta = "SELECT COUNT(b.idoperacion),  SUM(paradastotales) AS sumparadas, SUM(confrecuencia) AS sumconfrecuencia, SUM(prog) AS programados, CONCAT(FORMAT(SUM(confrecuencia) * 100 / SUM(prog),2), '%') efectividad_compra,
CONCAT(FORMAT((SUM(paradastotales - confrecuencia)/SUM(paradastotales))*100,2),' %') AS VisitadosNoProgramados 
FROM
(SELECT o.idoperacion, ppp, COUNT(distinct o.nud) paradastotales FROM orden o
INNER JOIN operaciones op ON op.idoperacion = o.idoperacion
INNER JOIN clientes c ON c.nud = o.nud AND c.iddeposito = op.iddeposito
WHERE  fecha > CURRENT_DATE GROUP BY idoperacion, ppp) a,
(SELECT o.idoperacion AS idoperacion, ppp AS idruta, count(distinct o.nud) AS confrecuencia FROM orden o
INNER JOIN operaciones op ON op.idoperacion = o.idoperacion 
INNER JOIN clientes c ON o.nud=c.nud AND c.iddeposito = op.idDeposito
WHERE  fecha > current_date AND dia LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(CURDATE()) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%')  -- and o.idoperacion = 8
GROUP BY idoperacion,ppp) b,
(SELECT idoperacion, ppp, COUNT(nud) AS prog FROM clientes c
INNER JOIN operaciones op ON op.iddeposito = c.iddeposito
WHERE dia LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(CURDATE()) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%')
GROUP BY idoperacion, ppp
) d
WHERE a.idoperacion = b.idoperacion AND a.ppp=b.idruta 
AND a.idoperacion = d.idoperacion AND a.ppp = d.ppp";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
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
        var data = google.visualization.arrayToDataTable([
          ['Clientes', 'V Programados', 'V no programados'],
          ['',   <?php echo $row['sumconfrecuencia']; ?>,<?php echo $row['sumparadas']-$row['sumconfrecuencia']; ?>],
        ]);

        var options = {
          chartArea: {top:"20%",width:"100%",height:"100%"},
          legend: 'top',
          title: 'Visitados No Programados',
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <center>
      <div class="divGrafica" id="chart_div" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">

      </div>
    </center>
  </body>
</html>