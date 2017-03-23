<?php
if (!isset($_SESSION))
{
	session_start();
}
date_default_timezone_set('America/Mexico_City');
$idoperacion = $_SESSION['idoperacion'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];

/*header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteAdministracionDetallado_".$fechaIni.'_'.date('H:i:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");*/

require_once('../clases/class.MySQL.php');
/*require_once('../dompdf/dompdf_config.inc.php');*/

$db = new MySQL();


/** array dias **/
$dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');

$fechaDia = $dias[date('N', strtotime($fechaIni))];

	if($fechaDia=='Sabado'){
		$fechaEntrega = strtotime ('+2 day', strtotime ($fechaIni));
	}
	else
	{
		$fechaEntrega = strtotime ('+1 day', strtotime ($fechaIni));
	}

	$fechaEntrega = date('Y-m-d', $fechaEntrega);

/** Query para obtener el idDeposito**/
$consultaDep = "SELECT d.idDeposito, d.deposito, r.region FROM Operaciones o
INNER JOIN Deposito d ON d.idDeposito = o.idDeposito
INNER JOIN Zona z ON z.idZona = d.idZona
INNER JOIN Region r ON r.idRegion = z.idRegion
WHERE o.idoperacion = ".$idoperacion." LIMIT 1";
$resultadoDep = $db->consulta($consultaDep);
$rowDep = $db->fetch_assoc($resultadoDep);

$idDeposito = $rowDep['idDeposito'];


$encabezado = "<tr>
			      <td width='250'><tt>Gepp</tt></td>
			    <!--  <td width='250'><tt>Compañía:</tt></td>
			      <td width='250'><tt>Gepp S de RL de CV</tt></td> -->
			      <td width='250'><tt>".date('Y-m-d H:i:s')."</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Reporte Bodega Detallado</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Deposito:</tt></td>
			      <td><tt>".$rowDep['idDeposito']." ".$rowDep['deposito']."</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Fecha Inicio</tt></td>
			      <td><tt>".$fechaIni."</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Fecha Fin</tt></td>
			      <td><tt>".$fechaFin."</tt></td>
			    </tr>";


				/** Query para obtener las rutas, clientes y fecha**/
					$consulta = "SELECT
					    cc.idruta,
					    ppp,
					    cc.nud,
					    c.nombre,
					    mo.descripcion,
					    pc.sku,
					    pc.DescripcionInterna,
					    pc.skuconver,
					    p.descripcion AS desp,
					    cc.cantidad,
					    cc.fechaCambio
					FROM
					    CapturaCambios cc
					        INNER JOIN
					    ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
					        INNER JOIN
					    productos p ON pc.skuConver = p.sku
					        INNER JOIN
					    Operaciones op ON op.idoperacion = cc.idoperacion
					        INNER JOIN
					    Clientes c ON c.nud = cc.nud
					        INNER JOIN
					    cambiosmotivos mo ON mo.idcambiosmotivos = cc.idcambiosmotivos
					WHERE
					    c.iddeposito = $idDeposito
					        AND cc.FechaCambio BETWEEN '$fechaIni' AND '$fechaFin'
					        AND cc.idoperacion = $idoperacion
					        AND estatusDis != 0
					ORDER BY cc.idruta , pc.sku";

				$resultado = $db->consulta($consulta);
				$row = $db->fetch_assoc($resultado);

				do{

					$tdBody  .= "<tr>
									<td><tt>".$row['fechaCambio']."</tt></td>
								    <td><tt>".$row['idruta']."</tt></td>
								    <td><tt>".$row['ppp']."</tt></td>
								    <td><tt>".$row['nud']."</tt></td>
								    <td><tt>".$row['nombre']."</tt></td>
								    <td><tt>".$row['descripcion']."</tt></td>
								    <td><tt>".$row['sku']."</tt></td>
								    <td><tt>".$row['DescripcionInterna']."</tt></td>
								    <td><tt>".$row['skuconver']."</tt></td>
								    <td><tt>".$row['desp']."</tt></td>
								    <td><tt>".$row['cantidad']."</tt></td>
								</tr>";

				}while($row = $db->fetch_assoc($resultado));

$html="<!doctype html>
		<html>
		<head>
		<meta charset='UTF-8'>
		<title>Reporte Bodega Detallado</title>
		</head>

		<body>
		<center>
			<table width='750' height='112' border='0'>
			  <tbody>
			    ".$encabezado."
			  </tbody>
			</table>
			<hr>
			<table width='750' height='112' border='0'>
			  <tbody>
			    <tr>
			    	<td width='20'><tt>Fecha Cambio</tt></td>
			      	<td width='20'><tt>OE</tt></td>
			      	<td width='20'><tt>PPP</tt></td>
			      	<td width='20'><tt>Nud</tt></td>
			      	<td width='20'><tt>Cliente</tt></td>
			      	<td width='20'><tt>Motivo</tt></td>
			      	<td width='20'><tt>SKU</tt></td>
			      	<td width='20'><tt>Producto</tt></td>
			      	<td width='20'><tt>SKU Conversión</tt></td>
			      	<td width='20'><tt>Producto Conversión</tt></td>
			      	<td width='20'><tt>Cantidad</tt></td>
			    </tr>
			    ".$tdBody."
			  </tbody>
			</table>
		</center>
		</body>
		</html>";

echo $html;

# Instanciamos un objeto de la clase DOMPDF.
/*$mipdf = new DOMPDF();

# Definimos el tamaño y orientación del papel que queremos.
# O por defecto cogerá el que está en el fichero de configuración.
$mipdf ->set_paper("A4", "portrait");

# Cargamos el contenido HTML.
$mipdf ->load_html(utf8_decode($html));

# Renderizamos el documento PDF.
$mipdf ->render();

# Enviamos el fichero PDF al navegador.
$mipdf ->stream("reporteAdministracionDetallado_".$fechaIni.'_'.date('H:i:s')."pdf");*/
?>
