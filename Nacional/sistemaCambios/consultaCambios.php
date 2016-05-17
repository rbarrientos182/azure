<?php include('header.php');

$idoperacion = $_SESSION['idoperacion'];

$consulta = "SELECT FechaCambio, Usuario FROM capturacambios cc INNER JOIN usrcambios uc ON cc.NumEmpleado = uc.NumEmpleado AND cc.idoperacion = ".$idoperacion." GROUP BY FechaCambio";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="consultaCambios.php">Reportes Cambios Motivos</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i>Reportes Cambios Motivos</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Fecha Cambios</th>
								  <th>Usuario</th>
								  <th>Impresion</th> 
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{?>
								<tr>
									<td class="center"><?php echo $row['FechaCambio']?></td>
									<td class="center"><?php echo $row['Usuario']?></td>									
									<td class="center">
										<a class="btn btn-danger" target="new" href="iSupervisorPdf.php?f=<?php echo $row['FechaCambio']; ?>">
											<i class="icon-print icon-white"></i> 
											Supervisor PDF
										</a> 
										<a class="btn btn-danger" target="new" href="iAlmacenPdf.php?f=<?php echo $row['FechaCambio']; ?>">
											<i class="icon-print icon-white"></i> 
											Almacen PDF
										</a>
										<a class="btn btn-danger" target="new" href="iVendedorPdf.php?f=<?php echo $row['FechaCambio']; ?>">
											<i class="icon-print icon-white"></i> 
											Vendedor PDF
										</a>

									</td>
								</tr>
							<?php }while($row = $db->fetch_assoc($resultado)); ?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->   
<?php include('footer.php'); ?>
