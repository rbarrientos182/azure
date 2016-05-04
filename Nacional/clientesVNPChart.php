<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$consulta = "SELECT deposito,COUNT(b.idoperacion),  sum(paradastotales)  as ptotales, sum(confrecuencia) as cfrecuencia,
sum(paradastotales) - sum(confrecuencia) as vnp, 
 sum(prog) as programados, concat(format(sum(confrecuencia) * 100 / sum(prog),2), '%') efectividad_compra,
concat(format((sum(paradastotales - confrecuencia)/sum(paradastotales))*100,2),' %') as VisitadosNoProgramados 
from
(select o.idoperacion, ppp, COUNT(distinct o.nud) paradastotales from orden o
inner join operaciones op on op.idoperacion = o.idoperacion
inner join clientes c on c.nud = o.nud and c.iddeposito = op.iddeposito
where  fecha > current_date group by idoperacion, ppp) a,
(SELECT o.idoperacion as idoperacion, ppp as idruta, COUNT(distinct o.nud) as confrecuencia from orden o
inner join operaciones op on op.idoperacion = o.idoperacion 
INNER JOIN clientes c on o.nud=c.nud and c.iddeposito = op.idDeposito
where  fecha > current_date and dia like concat('%',(SELECT CONCAT(ELT(WEEKDAY(curdate()) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%')  -- and o.idoperacion = 8
group BY idoperacion,ppp) b,
(select idoperacion, ppp, COUNT(nud) as prog from clientes c
inner join operaciones op on op.iddeposito = c.iddeposito
where dia like concat('%',(SELECT CONCAT(ELT(WEEKDAY(curdate()) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%')
group by idoperacion, ppp
) d,
(select deposito,d.iddeposito,idoperacion from deposito d, operaciones o where d.iddeposito = o.iddeposito)c
where a.idoperacion = b.idoperacion and a.ppp=b.idruta and a.idoperacion=c.idoperacion 
and a.idoperacion = d.idoperacion and a.ppp = d.ppp
group by b.idoperacion";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);
do{

  $cadenaDepositos .= "['".$row['deposito']."'".",".$row['vnp']."],";

}while($row = $mysqli->fetch_assoc($resultado));

$cadenaDepositos = substr($cadenaDepositos, 0,-1);
?>
<!DOCTYPE HTML>
<html lang="es">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
      Google Visualization API Sample
    </title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Deposito','VNP'],
          <?php echo $cadenaDepositos;?>
        ]);

        var options = {
          width: '100%', height: '100%',
          title: 'Visitados no Programados',
          vAxis: {title: 'Fecha Entrega',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
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
      google.setOnLoadCallback(drawChart);
    </script>
  </head>
  <body>
    <center>
      <div class="divGrafica" id="chart_div" style="height:700px;position: absolute; top: 50%; left: 50%;transform: translate(-50%, -50%);" ></div>
    </center>
  </body>
</html>