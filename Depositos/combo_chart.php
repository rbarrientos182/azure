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

//$mysqli = new mysqli('localhost','gepp','gepp','gepp');


$consulta = "SELECT a.idoperacion, a.ppp,  SUM(paradastotales) AS paradastotales , SUM(confrecuencia) AS confrecuencia, SUM(prog) AS programados, concat(format(SUM(confrecuencia) * 100 / SUM(prog),2), '%') AS efectividad_compra,
CONCAT(FORMAT((SUM(paradastotales - confrecuencia)/SUM(paradastotales))*100,2),' %') AS VisitadosNoProgramados, SUM(paradastotales - confrecuencia) AS vnp 
FROM
(SELECT o.idoperacion, ppp, COUNT(DISTINCT o.nud) paradastotales FROM orden o
INNER JOIN operaciones op ON op.idoperacion = o.idoperacion
INNER JOIN clientes c ON c.nud = o.nud AND c.iddeposito = op.iddeposito
WHERE  fecha = CURRENT_DATE AND o.idoperacion=8 GROUP BY idoperacion, ppp) a,

(SELECT o.idoperacion AS idoperacion, ppp AS idruta, COUNT(distinct o.nud) AS confrecuencia FROM orden o
INNER JOIN operaciones op ON op.idoperacion = o.idoperacion 
INNER JOIN clientes c ON o.nud=c.nud AND c.iddeposito = op.idDeposito
WHERE  fecha = CURRENT_DATE AND o.idoperacion=8 AND dia LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(CURDATE()) + 1, 'L', 'm', 'R', 'J', 'V', 'S', 'D'))),'%')  -- and o.idoperacion = 8
GROUP BY idoperacion,ppp) b,

(SELECT idoperacion, ppp, COUNT(nud) AS prog FROM clientes c
INNER JOIN operaciones op ON op.iddeposito = c.iddeposito
WHERE idoperacion=8 AND dia LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(CURDATE()) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%')
GROUP BY idoperacion, ppp) d

WHERE a.idoperacion = b.idoperacion AND a.ppp=b.idruta  
AND a.idoperacion = d.idoperacion AND a.ppp = d.ppp
GROUP BY b.idoperacion, a.ppp";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

//$resultado = $mysqli->query($consulta);
//$row = $resultado->fetch_assoc();

do{

  $cadenaDepositos .= "['".$row['ppp']."'".",".$row['vnp'].",".$row['programados']."],";


}while($row = $resultado->fetch_assoc());

$cadenaDepositos = substr($cadenaDepositos, 0,-1);
//echo '<br>';
?>
<!DOCTYPE HTML>
<html lang="es">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
      Gepp
    </title>
        <script type="text/javascript" src="js/jquery.flot.min.js"></script>
        <script type="text/javascript" src="js/jquery.flot.pie.min.js"></script>
        <script type="text/javascript" src="js/jquery.flot.resize.js"></script>
        <script type="text/javascript" src="js/jquery.flot.pie.stack.js"></script>
  </head>
  <body>
    <center>
        <div id="chart_div" style="overflow:hidden;height:97%; width:97%; position: absolute;top:0;left:0;right:0;bottom:0;margin: auto;">
    </center>
     <?php $mysqli->free();?>
    </div>
  </body>
</html>