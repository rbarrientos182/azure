<?php
if (!isset($_SESSION)) 
{
	session_start();
} 
require_once('clases/class.MySQL.php');
$no_visible_elements=true;
$db = new MySQL();

/** Recibimo las variables enviadas por el form via post **/

$fDel = $_POST['fDel'];
$fAl = $_POST['fAl'];
$idPr = $_POST['idPr'];
$idMo = $_POST['idMo'];
$idoperacion = $_SESSION['idoperacion'];

$condicionP	= NULL;
$condicionM = NULL;

if($idPr!=0) {
	$condicionP = " AND pc.idProductoCambio = ".$idPr;
}


if($idMo!=0) {
	$condicionM = " AND cm.idCambiosMotivos = ".$idMo;
}

$consulta2 = "SELECT idDeposito FROM Operaciones WHERE idoperacion = ".$idoperacion;
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);

$idDeposito = $row2['idDeposito'];

$consulta =  "SELECT uc.NumEmpleado, uc.Nombre AS nomEmpleado, uc.ppp,cc.idruta, cc.nud, cc.cantidad, c.nombre, pc.DescripcionInterna, cm.Descripcion FROM CapturaCambios cc INNER JOIN CambiosMotivos cm ON cc.idCambiosMotivos = cm.idCambiosMotivos INNER JOIN ProductosCambios pc ON cc.idProductoCambio = pc.idProductoCambio INNER JOIN UsrCambios uc ON cc.NumEmpleado = uc.NumEmpleado INNER JOIN Clientes c ON c.nud = cc.nud AND c.idDeposito = $idDeposito  AND cc.idoperacion = $idoperacion AND FechaCambio BETWEEN '$fDel' AND '$fDel' ORDER BY cc.idRuta";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div id="dTablaClientes" class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Preventa</th>
								  <th>No. Empleado</th>
								  <th>Preventista</th>
								  <th>Entrega</th>
								  <th>NUD</th>
								  <th>Cliente</th>
								  <th>Producto</th>
								  <th>Motivo</th>
								  <th>Cantidad</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php 
						  		do{
						  	?>
								<tr>
									<td class="center"><?php echo $row['ppp'];?></td>
									<td class="center"><?php echo $row['NumEmpleado'];?></td>
									<td class="center"><?php echo utf8_encode($row['nomEmpleado']);?></td>
									<td class="center"><?php echo $row['idruta'];?></td>
									<td class="center"><?php echo $row['nud'];?></td>
									<td class="center"><?php echo utf8_encode($row['nombre']);?></td>
									<td class="center"><?php echo utf8_encode($row['DescripcionInterna']);?></td>
									<td class="center"><?php echo utf8_encode($row['Descripcion']);?></td>
									<td class="center"><?php echo $row['cantidad'];?></td>
								</tr>
							<?php 
								}while($row = $db->fetch_assoc($resultado));
								$db->liberar($resultado);
							?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

<?php include('footer_min.php'); ?>
