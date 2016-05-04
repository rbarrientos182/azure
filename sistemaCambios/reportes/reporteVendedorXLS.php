<?php 
if (!isset($_SESSION)) 
{
	session_start();
}
date_default_timezone_set('America/Mexico_City');
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteVendedor.xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../clases/class.MySQL.php');

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$fechaPreventa = $_POST['fechaPre'];

/** array dias **/
$dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');

$fechaDia = $dias[date('N', strtotime($fechaPreventa))];

	if($fechaDia=='Sabado'){
		$fechaEntrega = strtotime ('+2 day', strtotime ($fechaPreventa));
	}
	else
	{
		$fechaEntrega = strtotime ('+1 day', strtotime ($fechaPreventa));
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

$encabezado = '<tr>
			      <td width="250"><tt>Gepp México</tt></td>
			      <td width="250"><tt>Compañía:</tt></td>
			      <td width="250"><tt>Gepp S de RL de CV</tt></td>
			      <td width="250"><tt>'.date('Y-m-d H:i:s').'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Reporte de Cambios</tt></td>
			      <td><tt>Bodega:</tt></td>
			      <td><tt>'.$rowDep['idDeposito'].' '.$rowDep['deposito'].'</tt></td>
			    </tr>
			    <tr>
			      <td><tt>Grupos Supervisión:</tt></td>
			      <td><tt>Localidad:</tt></td>
			      <td><tt>'.$rowDep['region'].'</tt></td>
			    </tr>
			    <tr>
			      <td><tt></tt></td>
			      <td><tt>Fecha Preventa</tt></td>
			      <td><tt>'.$fechaPreventa.'</tt></td>
			    </tr>
			    <tr>
			      <td><tt></tt></td>
			      <td><tt>Fecha Entrega</tt></td>
			      <td><tt>'.$fechaEntrega.'</tt></td>
			    </tr>';

	$consulta = "SELECT 
    cc.idruta,
    cc.nud,
    c.nombre,
    pc.sku,
    pc.DescripcionInterna,
    pc.skuconver,
    pr.Descripcion,
    cc.cantidad
	FROM
	    CapturaCambios cc
			
	        INNER JOIN
	    ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio
	    inner join 
	        productos pr ON pc.skuconver=pr.sku
	        INNER JOIN
	    Clientes c ON c.nud = cc.nud
	WHERE
	    c.iddeposito = $idDeposito
	        AND cc.FechaCambio = '$fechaPreventa'
	        AND cc.idoperacion = $idoperacion
	ORDER BY cc.idruta , cc.nud";

	
	$resultado = $db->consulta($consulta);
	$row = $db->fetch_assoc($resultado);
	$sumaTotal = 0;
	$nud = $row['nud'];
	$bandera = 0;
	do{
		
		$nudIni = $row['nud'];

		$idruta = $row['idruta'];
		$nudC = $row['nud'];
		$nombre = $row['nombre'];

		if($nud!=$nudIni){

			$tr2 = '<tr>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td>&nbsp;</td>
				      <td><tt>'.$sumaTotal.'</tt></td>
				      <td><tt>Firma del Cliente</tt></td>
    				</tr>';

    		$sumaTotal = 0;		

		}
		else{
			if($bandera ==0){
				$bandera=1;
			}
			else{
				$idruta = NULL;
				$nudC = NULL;
				$nombre = NULL;

			}

		}
		$sumaTotal = $sumaTotal + $row['cantidad'];
		$sumaTotal = $sumaTotal;

		$nud = $nudIni;
		$tdBody .= $tr2.'<tr>
						<td><tt>'.$idruta.'</tt></td>
						<td><tt>'.$nudC.'</tt></td>
						<td><tt>'.$nombre.'</tt></td>
						<td><tt>'.$row['sku'].'</tt></td>
						<td><tt>'.$row['DescripcionInterna'].'</tt></td>
						<td><tt>'.$row['skuconver'].'</tt></td>
						<td><tt>'.$row['Descripcion'].'</tt></td>
						<td><tt>'.$row['cantidad'].'</tt></td>
					</tr>';
		$tr2 = NULL;			
				
	}while($row = $db->fetch_assoc($resultado));

	$tr2 = '<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><tt>'.$sumaTotal.'</tt></td>
				<td><tt>Firma del Cliente</tt></td>
    		</tr>';

	$tdBody .= $tr2.'<tr>
						<td><tt>'.$row['idruta'].'</tt></td>
						<td><tt>'.$row['nud'].'</tt></td>
						<td><tt>'.$row['nombre'].'</tt></td>
						<td><tt>'.$row['sku'].'</tt></td>
						<td><tt>'.$row['DescripcionInterna'].'</tt></td>
						<td><tt>'.$row['skuconver'].'</tt></td>
						<td><tt>'.$row['Descripcion'].'</tt></td>
						<td><tt>'.$row['cantidad'].'</tt></td>
					</tr>';

?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Documento sin título</title>
	</head>
		
	<body>
		<table width="750" height="112" border="0">
			<tbody>
				<?php echo $encabezado;?>
			</tbody>
		</table>
		<p>&nbsp;</p>
		<hr>
		<p>&nbsp;</p>
		<table width="750" height="112" border="0">
			<tbody>
				<tr>
				<td width="50"><tt>Ruta</tt></td>
				<td width="50"><tt>Nud</tt></td>
				<td width="50"><tt>Cliente</tt></td>
				<td width="50"><tt>Sku</tt></td>
				<td width="50"><tt>Producto</tt></td>
				<td width="50"><tt>Sku Conversión</tt></td>
				<td width="50"><tt>Producto conversión</tt></td>
				<td width="50"><tt>Cantidad Pzas</tt></td>
				<td width="50">&nbsp;</td>
				</tr>
				<?php echo $tdBody;?>
			</tbody>
		</table>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
	</body>
</html>';


