<!DOCTYPE HTML>
<html lang="es">
<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

 $consulta = "SELECT mnud, tnud from 
(SELECT idoperacion, count(nud) as mnud from orden where fecha > current_date and cfisicas < 2 ) a,
(SELECT idoperacion, count(nud) as tnud from orden where fecha > current_date  ) b, 
(Select idoperacion, deposito from operaciones o inner join deposito d on o.iddeposito=d.iddeposito) c
where a.idoperacion=c.idoperacion";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
//echo $consulta;
?>  
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
                  text: 'Clientes < 2 cajas'
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
                  name: 'Clientes',
                  data: [
                      {
                       name: 'Clientes < 2 cajas',
                       y:<?php echo $row['mnud']; ?>,
                       color: '#1A92F4'
                     },
                     {
                      name:'Total Clientes',
                      y:<?php echo $row['tnud']-$row['mnud']; ?>,
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
      <div  class="divGrafica" id="piechart_3d" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">
        
      </div>
       <?php $mysqli->liberar($resultado);?>
    </center>
  </body>
</html>