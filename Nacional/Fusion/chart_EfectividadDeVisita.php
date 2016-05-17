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
require_once("clases/class.Utilidades.php");

$mysqli = new MySQL();
$uti = new Utilidades();

$intervalo = $uti->obtenerIntervalo();
$iddeposito = $_GET['iddeposito'];

$consulta = "SELECT FORMAT(AVG((clientesvp/clientesProg) * 100),1) AS Efectividad_Visita
FROM resumen_ruta WHERE iddeposito=$iddeposito AND fechaOperacion = DATE_SUB(CURRENT_DATE,INTERVAL $intervalo DAY) AND tiporuta=6 AND CURRENT_TIME < '13:00:00'
GROUP BY iddeposito";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

if ($row['Efectividad_Visita']=='') {
  $row['Efectividad_Visita']=0;
}

$valor=0;

if($row['Efectividad_Visita']<100){
   
   $valor=100-$row['Efectividad_Visita'];
}

?>
<!DOCTYPE HTML>
<html>
  <head>
        <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
        <script src="js/amcharts.js"></script>
        <script src="js/gauge.js"></script>
        <script src="js/dark.js"></script>
        <script src="js/light.js"></script>

        <script>
        var gaugeChart = AmCharts.makeChart("chart_div", {
          "type": "gauge",
          "theme": "light",
          "axes": [ {
            "axisThickness": 1,
            "axisAlpha": 0.2,
            "tickAlpha": 0.2,
            "valueInterval": 10,
            "bands": [ {
              "color": "#cc4748",
              "endValue": 80,
              "startValue": 60
            }, {
              "color": "#fdd400",
              "endValue": 95,
              "startValue": 80
            }, {
              "color": "#84b761",
              "endValue": 100,
              "innerRadius": "95%",
              "startValue": 95
            } ],
            "bottomText": "0 %",
            "bottomTextYOffset": -20,
            "endValue": 100
          } ],
          "arrows": [ {} ],
          "export": {
            "enabled": true
          }
        } );

        setInterval(randomValue, 500);

        // set random value
        function randomValue() {
          var value = <?php echo $row['Efectividad_Visita']?>;
          if ( gaugeChart ) {
            if ( gaugeChart.arrows ) {
              if ( gaugeChart.arrows[ 0 ] ) {
                if ( gaugeChart.arrows[ 0 ].setValue ) {
                  gaugeChart.arrows[ 0 ].setValue( value );
                  gaugeChart.axes[ 0 ].setBottomText("Efectividad Visita \n \n"+ value + "%" );
                }
              }
            }
          }
        }
        </script>
  <link rel="stylesheet" type="text/css" href="css/stylegrafica.css">
  </head>
  <body>
    <center>
      <div  id='chart_div' class="divGrafica"></div>
      <?php $mysqli->liberar($resultado);?>
    </center>
  </body>
</html>

