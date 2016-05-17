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

$consulta = "SELECT 
r.idruta,
a.km AS KM_Teorico,
r.odometrofin - r.odometroini AS KM_Real,
IF(ISNULL(KM_ant),0,KM_ant) AS KM_ant
FROM resumen_ruta r INNER JOIN
(SELECT b.iddeposito AS iddeposito,fecha,idruta,km FROM orden a INNER JOIN operaciones b ON a.idoperacion = b.idoperacion WHERE fecha = DATE_SUB(CURRENT_DATE,INTERVAL 1 DAY) AND iddeposito = $iddeposito GROUP BY idruta) a 
ON a.iddeposito = r.iddeposito AND a.fecha = r.fechaoperacion AND r.idruta = a.idruta
LEFT JOIN
(SELECT iddeposito AS iddeposito,fechaoperacion,idruta,r.odometrofin - r.odometroini AS KM_Ant FROM resumen_ruta r WHERE fechaoperacion = DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) AND iddeposito = $iddeposito AND tiporuta=6 GROUP BY idruta) b
ON r.iddeposito=b.iddeposito AND r.fechaoperacion = DATE_SUB(CURRENT_DATE,INTERVAL 1 DAY) AND r.idruta=b.idruta
WHERE r.iddeposito = $iddeposito AND r.fechaOperacion = DATE_SUB(CURRENT_DATE,INTERVAL 1 DAY) AND tiporuta = 6 AND CURRENT_TIME < '13:00:00'
ORDER BY r.idruta";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

do{

  $cadenaRuta .= "'".$row['idruta']."',";
  $cadenaKMT .= $row['KM_Teorico'].",";
  $cadenaKMR .= $row['KM_ant'].",";


}while($row = $resultado->fetch_assoc());

$cadenaRuta = substr($cadenaRuta, 0,-1);
$cadenaKMT = substr($cadenaKMT, 0,-1);
$cadenaKMR = substr($cadenaKMR, 0,-1);
//echo '<br>';
?>
<!DOCTYPE HTML>
<html lang="es">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
      Gepp
    </title>

    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/highcharts.js"></script>
    <script >
      $(function () {
          $('#chart_div').highcharts({
              chart: {
                type: 'bar'
              },
              title: {
                text: 'KM Prog. Vs KM Real Semana Anterior'
              },
              xAxis: {
                categories: [<?php echo $cadenaRuta;?>]
              },
              yAxis: {
                min: 1,
                minTickInterval: 5,
                title: {
                  text: 'Km'
                }
              },
              legend: {
                reversed: true
              },
              plotOptions: {
                series: {
                  stacking: 'normal'
                }
              },
              series: [{
                name: 'Km Programado',
                tooltip:{valueSuffix: ' Km'},
                data: [<?php echo $cadenaKMT;?>],
                color: '#1A92F4' //AZUL
                },{
                type:'spline',
                name: 'KM Real Semana Ant.',
                tooltip:{valueSuffix: ' Km'},
                data: [<?php echo $cadenaKMR;?>],
                color: '#0015FE' //CELESTE
                }]
          });
      });
    </script>
  </head>
  <body>
    <center>
      <div id="chart_div" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">  
        <?php $mysqli->free();?>
      </div>
    </center>
  </body>
</html>