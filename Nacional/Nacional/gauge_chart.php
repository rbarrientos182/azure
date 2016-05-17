<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$consulta = "SELECT  FORMAT(AVG(Capacidad),1) AS Capacidad FROM
(SELECT  o.idoperacion AS idoperacion, o.idruta ,  ROUND((SUM(cfisicas)*100)/capacidad,1) AS Capacidad  FROM orden o
LEFT JOIN (SELECT idoperacion, idruta, capacidad FROM Ruta r INNER JOIN Unidades u ON r.idunidades=u.idunidades) a
ON o.idoperacion=a.idoperacion AND o.idruta=a.idruta
WHERE fecha > CURRENT_DATE 
GROUP BY o.idoperacion, o.idruta) b";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
//echo $consulta;
?>
<!DOCTYPE HTML>
<html>
  <head>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/highcharts.js"></script>
    <script src="js/highcharts-more.js"></script>
    <script>
            //******* GAUGE CHART
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
                        text: 'Capacidad'
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
                            text: 'E.V.'
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
                        name: '% Carga',
                        data: [<?php echo $row['Capacidad']; ?>],
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
  </head>
  <body>
    <center>
      <div class="divGrafica" id='chart_div' style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;"></div>
      <?php $mysqli->liberar($resultado);?>
    </center>
  </body>
</html>

