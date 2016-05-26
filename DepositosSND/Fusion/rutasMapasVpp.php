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
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$iddeposito = $_POST['iddeposito'];
$consulta = "SELECT 
      r.idruta,
      IF(ISNULL(nudsvnp),0,nudsvnp) AS pppVNP,
      IF(ISNULL(clientesVNP),0,clientesVNP) AS vppVNP,
      CONCAT(FORMAT((r.clientesvp/r.clientesProg) * 100,1),'%') AS Efectividad_Visita,
      CONCAT(FORMAT((r.clientescv/r.clientesProg) * 100,1),'%') AS Efectividad_EntregaClientes,
      CONCAT(FORMAT((r.cajasef/r.cajaspfp) * 100,1),'%') AS Efectividad_EntregaCajas,
      IF(FORMAT((r.clientesvp/r.clientesProg) * 100,1)<98,'rRojo','rVerde') AS classEfectividadVisita,
      IF(FORMAT((r.clientescv/r.clientesProg) * 100,1)<98,'rRojo','rVerde') AS classEntregaClientes,
      IF(FORMAT((r.cajasef/r.cajaspfp) * 100,1)<98,'rRojo',IF(FORMAT((r.cajasef/r.cajaspfp) * 100,1)<100,'rVerde','rAmarillo')) AS classEntregaCajas
      FROM resumen_ruta r 
      LEFT JOIN (
      SELECT b.iddeposito AS iddeposito, fecha, idruta, km, COUNT(nud) AS paradas, SUM(cfisicas) AS cajasFisicas, SUM(csio) AS cajassio 
      FROM orden a 
      INNER JOIN operaciones b ON a.idoperacion = b.idoperacion 
      WHERE fecha = DATE_SUB(CURRENT_DATE,INTERVAL $intervalo DAY) AND iddeposito = $iddeposito 
      GROUP BY idruta
      ) a ON a.iddeposito = r.iddeposito AND a.fecha = r.fechaoperacion  AND r.idruta = a.idruta
      LEFT JOIN (
      SELECT d.iddeposito, vpp, 
      COUNT(o.nud) nudsvnp 
      FROM orden o 
      INNER JOIN operaciones op ON op.idoperacion = o.idoperacion
      INNER JOIN deposito d ON d.iddeposito = op.iddeposito
      INNER JOIN clientes c ON o.nud = c.nud AND c.iddeposito = d.idDeposito
      WHERE dia NOT LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(fecha_preventa) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%') AND c.iddeposito = $iddeposito
      AND fecha = DATE_SUB(CURRENT_DATE,INTERVAL $intervalo DAY) 
      GROUP BY d.idDeposito, vpp
      ) ffrec ON ffrec.iddeposito = r.iddeposito AND ffrec.vpp = r.idruta 
      WHERE r.iddeposito = $iddeposito AND r.fechaOperacion = DATE_SUB(CURRENT_DATE,INTERVAL $intervalo DAY) AND tiporuta = 6
	  LIMIT $inicio , $fin";
	  $resultado = $mysqli->consulta($consulta);
	  $row = $mysqli->fetch_assoc($resultado);
?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title>Gepp</title>
	</head>
	<body>
	  <table id="tabla" class="table table-condensed table-bordered">
      <thead>
        <tr> 
          <th colspan="3" class="text-center">Servicio</th>
        </tr>
        <tr >
          <!--<th class="text-center">Deposito</th>-->
          <th class="text-center">Ruta</th>
          <th class="text-center">Efectividad<br> Visita</th>
          <th class="text-center">Efectividad <br>Entrega Clientes</th>
          <!--<th class="text-center">Efectividad <br>Entrega Cajas</th>-->
        </tr>
      </thead>
      <tbody>
        <?php
        do{
        ?>
          <tr>
            <td><?php echo $row['idruta'];?></td>
            <td class="<?php echo $row['classEfectividadVisita']?>"><?php echo $row['Efectividad_Visita'];?></td>
            <td class="<?php echo $row['classEntregaClientes']?>"><?php echo $row['Efectividad_EntregaClientes'];?></td>
            <!--<td class="<?php echo $row['classEntregaCajas']?>"><?php echo $row['Efectividad_EntregaCajas'];?></td>-->
          </tr>
        <?php 
        }while($row = $mysqli->fetch_assoc($resultado));
        $mysqli->liberar($resultado);
        ?>
      </tbody>  
    </table>
	</body>
</html>