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
    fechaoperacion,
    (SELECT 
            CONCAT(ELT(WEEKDAY(fechaoperacion) + 1,
                                'Lunes',
                                'Martes',
                                'Miercoles',
                                'Jueves',
                                'Viernes',
                                'Sabado',
                                'Domingo'))
        ) AS dia,
    FORMAT(AVG((clientescv / clientesProg) * 100),1) AS Efectividad_EntregaClientes
FROM
    resumen_ruta
WHERE
    iddeposito = $iddeposito
        AND fechaOperacion > DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
        AND tiporuta = 6
GROUP BY fechaoperacion , iddeposito
ORDER BY fechaOperacion";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

do{
    $cadena .= "'".$row['dia']."',";
    $fecha = explode('-', $row['fechaoperacion']);

    $fecharesta = $fecha[1]-1;
    $fecha[1] = $fecharesta;
    

    if($fecha[2]<10){
         $fecha[2] = substr($fecha[2],1);
    }

    $cadena2 .= $row['Efectividad_EntregaClientes'].",";

    $cadenaDias .= '{"dia": "'.$row['dia'].'","porcentaje": '.$row['Efectividad_EntregaClientes'].'},';
}while($row = $mysqli->fetch_assoc($resultado));

$cadena = substr($cadena, 0, -1);
$cadena2 = substr($cadena2, 0, -1);

$cadenaDias = substr($cadenaDias,0,-1);
?>
<!DOCTYPE HTML>
<html>
  <head>
        <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
        <script src="js/amcharts.js"></script>
        <script src="js/serial.js"></script>
        <script src="js/light.js"></script>

        <script>
            var chart = AmCharts.makeChart("container", {
              "type": "serial",
              "theme": "light",
              "dataProvider": [<?php echo $cadenaDias;?>],
              "gridAboveGraphs": true,
              "startDuration": 1,
              "legend": {
                "useGraphSettings": true,
                "markerSize":15,
                "valueWidth":0,
                "verticalGap":0
                },
              "graphs": [ {
                "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>",
                "bullet": "round",
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "useLineColorForBulletBorder": true,
                "fillAlphas": 0,
                "lineThickness": 2,
                "lineAlpha": 1,
                "bulletSize": 7,
                "title": "Efectividad Entrega Clientes",
                "valueField": "porcentaje",
              } ],
              "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
              },
              "categoryField": "dia",
              "categoryAxis": {
                "gridPosition": "start",
                "gridAlpha": 0,
                "tickPosition": "start",
                "tickLength": 20
              },
              "export": {
                "enabled": false
              }

            } );         
        </script>

        <link rel="stylesheet" type="text/css" href="css/stylegrafica.css">
  </head>
  <body>
      <div id="container" class='divGrafica'></div>
      <?php $mysqli->liberar($resultado);?>
  </body>
</html>