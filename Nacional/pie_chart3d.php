<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");
$mysqli = new MySQL();

$consulta = "SELECT sum(a.idruta) as Total, if(isnull(sum(b.idruta)),0,sum(b.idruta)) as Programado, (sum(a.idruta)-if(isnull(sum(b.idruta)),0,sum(b.idruta)) ) as optimizado from 
(select count(idruta) as idruta, idoperacion from ruta group by idoperacion) a
Left Join (select count(distinct idruta) as idruta, idoperacion from orden WHERE fecha > current_date group by idoperacion) b
ON a.idoperacion=b.idoperacion";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
//echo $consulta;
?>
<html>
  <head>
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
          width: '100%', height: '100%',
          title: 'En construcción',
          is3D: true,
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
    <div class="divGrafica" id="piechart_3d" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">

    </div>
  </body>
</html>