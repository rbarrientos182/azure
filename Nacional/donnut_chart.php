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
<!DOCTYPE HTML>
<html lang="es">
  <head>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/highcharts.js"></script>
    <script src="js/highcharts-more.js"></script>
    <script type="text/javascript">
      $(function () {
          $('#piechart_3d').highcharts({
              chart: {
                  plotBackgroundColor: null,
                  plotBorderWidth: null,//null,
                  plotShadow: false
              },
              title: {
                  text: 'Rutas'
              },
              tooltip: {
                  pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
              },
              plotOptions: {
                  pie: {
                      allowPointSelect: true,
                      cursor: 'pointer',
                      dataLabels: {
                          enabled: true,
                          format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                          style: { 
                          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                          }
                      }
                  }
              },
              series: [{
                  type: 'pie',
                  name: 'Rutas',
                  data: [
                      {
                        name:'Programadas',
                        y:<?php echo $row['Programado']; ?>,
                        color: '#1A92F4'
                      },
                      {
                        name:'Sin Programar',
                        y:<?php echo $row['optimizado']; ?>,
                        color: '#0015FE'
                      } 
                  ]
              }]
          });
      });
    </script>
  </head>
  <body>
    <center>
      <div class="divGrafica" id="piechart_3d" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">
      </div>
       <?php $mysqli->free();?>
    </center>
  </body>
</html>