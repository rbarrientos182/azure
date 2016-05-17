<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$consulta = "SELECT deposito,o.idoperacion,IF(ISNULL(ppp),0,ppp) as ppp, IF(ISNULL(vnp),0,vnp) AS vnp from deposito d inner join operaciones o on d.iddeposito=o.iddeposito left join  
(select a.idoperacion, count(b.idoperacion) as ppp,  sum(paradastotales) as paradastotales , sum(confrecuencia) as confrecuencia, sum(prog) as programados, concat(format(sum(confrecuencia) * 100 / sum(prog),2), '%') as efectividad_compra,
concat(format((sum(paradastotales - confrecuencia)/sum(paradastotales))*100,2),' %') as VisitadosNoProgramados, sum(paradastotales - confrecuencia) as vnp 
from
(select o.idoperacion, ppp, count(distinct o.nud) paradastotales from orden o
inner join operaciones op on op.idoperacion = o.idoperacion
inner join clientes c on c.nud = o.nud and c.iddeposito = op.iddeposito
where  fecha > current_date group by idoperacion, ppp) a,
(SELECT o.idoperacion as idoperacion, ppp as idruta, count(distinct o.nud) as confrecuencia from orden o
inner join operaciones op on op.idoperacion = o.idoperacion 
INNER JOIN clientes c on o.nud=c.nud and c.iddeposito = op.idDeposito
where  fecha > current_date and dia like concat('%',(SELECT CONCAT(ELT(WEEKDAY(curdate()) + 1, 'L', 'm', 'R', 'J', 'V', 'S', 'D'))),'%')  -- and o.idoperacion = 8
group BY idoperacion,ppp) b,
(select idoperacion, ppp, count(nud) as prog from clientes c
inner join operaciones op on op.iddeposito = c.iddeposito
where dia like concat('%',(SELECT CONCAT(ELT(WEEKDAY(curdate()) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%')
group by idoperacion, ppp) d
where a.idoperacion = b.idoperacion and a.ppp=b.idruta  
and a.idoperacion = d.idoperacion and a.ppp = d.ppp
group by b.idoperacion) x on o.idoperacion=x.idoperacion order by deposito";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

do{

  $cadenaDepositos .= "'".$row['deposito']."',";
  $cadenaVnp .= $row['vnp'].",";
  $cadenaPpp .= $row['ppp'].",";


}while($row = $mysqli->fetch_assoc($resultado));

$cadenaDepositos = substr($cadenaDepositos, 0,-1);
$cadenaVnp = substr($cadenaVnp, 0,-1);
$cadenaPpp = substr($cadenaPpp, 0,-1);
//echo '<br>';
?>
<!DOCTYPE HTML>
<html lang="es">
  <head>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/highcharts.js"></script>
    <script src="js/highcharts-more.js"></script>
    <script type="text/javascript">
      $(function () {
                    $('#chart_div').highcharts({
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Visitados no Programados'
                        },
                        xAxis: {
                            categories: [<?php echo $cadenaDepositos;?>]
                        },
                        yAxis: {
                            min: 1,
                            minTickInterval: 5,
                            title: {
                                text: 'Clientes'
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
                          name: 'VNP',
                          tooltip:{valueSuffix: ' VNP'},
                          data: [<?php echo $cadenaVnp;?>],
                          color: '#1A92F4' //AZUL
                         
                            },{
                          type:'spline',
                          name: 'PPP',
                          tooltip:{valueSuffix: ' PPP'},
                          data: [<?php echo $cadenaPpp;?>],
                          color: '#0015FE' //CELESTE
                            }]
                    });
        });   
    </script>
  </head>
  <body>
    <center>
        <div class="divGrafica" id="chart_div" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">
    </center>
     <?php $mysqli->free();?>
    </div>
  </body>
</html>