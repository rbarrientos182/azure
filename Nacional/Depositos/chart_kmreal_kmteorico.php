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
(SELECT b.iddeposito AS iddeposito,fecha,idruta,km FROM orden a INNER JOIN operaciones b ON a.idoperacion = b.idoperacion WHERE fecha = CURRENT_DATE AND iddeposito = $iddeposito GROUP BY idruta) a 
ON a.iddeposito = r.iddeposito AND a.fecha = r.fechaoperacion AND r.idruta = a.idruta
LEFT JOIN
(SELECT iddeposito AS iddeposito,fechaoperacion,idruta,r.odometrofin - r.odometroini AS KM_Ant FROM resumen_ruta r WHERE fechaoperacion = DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) AND iddeposito = $iddeposito AND tiporuta=6 GROUP BY idruta) b
ON r.iddeposito=b.iddeposito AND r.fechaoperacion = CURRENT_DATE AND r.idruta=b.idruta
WHERE r.iddeposito = $iddeposito AND r.fechaOperacion = CURRENT_DATE AND tiporuta = 6
ORDER BY r.idruta";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

do{

  $cadenaRuta .= "'".$row['idruta']."',";
  $cadenaKMT .= $row['KM_Teorico'].",";
  $cadenaKMR .= $row['KM_Real'].",";

  $cadenaRutas .= '{"ruta": '.$row['idruta'].',"kmprogramado": '.$row['KM_Teorico'].',"kmreal": '.$row['KM_Real'].'},';


}while($row = $resultado->fetch_assoc());

$cadenaRuta = substr($cadenaRuta, 0,-1);
$cadenaKMT = substr($cadenaKMT, 0,-1);
$cadenaKMR = substr($cadenaKMR, 0,-1);

$cadenaRutas = substr($cadenaRutas, 0,-1);
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
    <script src="js/amcharts.js"></script>
    <script src="js/serial.js"></script>
    <script src="js/light.js"></script>
    <script >
        var chart = AmCharts.makeChart("chart_div", {
        "type": "serial",
        "theme": "light",  
        "handDrawn":true,
        "handDrawScatter":0,
        "legend": {
            "useGraphSettings": true,
            "markerSize":12,
            "valueWidth":0,
            "verticalGap":0
        },
        "dataProvider": [
          <?php echo $cadenaRutas;?>
          ],
        "valueAxes": [{
            "minorGridAlpha": 0.08,
            "minorGridEnabled": true,
            "position": "top",
            "axisAlpha":0
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>",
            "title": "KM Programado",
            "type": "column",
            "fillAlphas": 0.8,
             
            "valueField": "kmprogramado"
        }, {
            "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "useLineColorForBulletBorder": true,
            "fillAlphas": 0,
            "lineThickness": 2,
            "lineAlpha": 1,
            "bulletSize": 7,
             "title": "KM Real",
            "valueField": "kmreal"
        }],
        "rotate": true,
        "categoryField": "ruta",
        "categoryAxis": {
            "gridPosition": "start"
        },
        "export": {
          "enabled": true
         }
    });
    </script>
  </head>
  <body>
    <center>
        <div id="chart_div" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">
    </center>
     <?php $mysqli->free();?>
    </div>
  </body>
</html>