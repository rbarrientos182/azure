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

$consulta = "SELECT FORMAT(AVG((cajasef/cajaspfp) * 100),1) AS Efectividad_EntregaCajas
FROM resumen_ruta WHERE iddeposito=$iddeposito AND fechaOperacion=CURRENT_DATE AND tiporuta=6
GROUP BY iddeposito";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

if ($row['Efectividad_EntregaCajas']=='') {
  $row['Efectividad_EntregaCajas']=0;
}

$valor=0;

if($row['Efectividad_EntregaCajas']<100){
   
   $valor=100-$row['Efectividad_EntregaCajas'];
}


?>
<!DOCTYPE HTML>
<html>
  <head>
        <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
        <script src="js/highcharts.js"></script>
        <script src="js/highcharts-more.js"></script>

  <script>
      //******* PIE CHART
$(function () {

    $('#chart_div').highcharts({

        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },

        title: {
            text: 'Efectividad Entrega Cajas'
        },

        pane: {
            startAngle: -150,
            endAngle: 150,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },

        // the value axis
        yAxis: {
            min: 0,
            max: 100,

            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            /*title: {
                text: 'E.E.C'
            },*/
            plotBands: [{
                from: 95,
                to: 100,
                color: '#55BF3B' // green
            }, {
                from: 80,
                to: 95,
                color: '#DDDF0D' // yellow
            }, {
                from: 60,
                to: 80,
                color: '#DF5353' // red
            }]
        },

        series: [{
            name: 'Efectividad De Entrega Cajas',
            data: [<?php echo $row['Efectividad_EntregaCajas']; ?>],
            tooltip: {
                valueSuffix: '%'
            }
        }]

    },
        // Add some life
        function (chart) {
            if (!chart.renderer.forExport) {
                
                    var point = chart.series[0].points[0],
                        newVal,
                        //inc = Math.round((Math.random() - 0.5) * 20);

                    newVal = point.y;
                    //if (newVal < 0 || newVal > 100) {
                        //newVal = point.y;
                    //}

                    point.update(newVal);

            }
        });
});
  
  </script>
  <link rel="stylesheet" type="text/css" href="css/stylegrafica.css">
  </head>
  <body>
    <center>
      <div  id='chart_div' class='divGrafica'></div>
      <?php $mysqli->liberar($resultado);?>
    </center>
  </body>
</html>