<?php include('header.php');

$idoperacion = $_SESSION['idoperacion'];

/** Query del catalogo de cambios de productos **/
$consulta = "SELECT 
    g.idgruposupervision,
    numgrupo,
    g.NumEmpleado,
    nombre,
    COUNT(ruta) as rutas
FROM
    gruposupervision g
        LEFT JOIN
    rutascambios r ON g.idgruposupervision = r.idgruposupervision
        AND g.idoperacion = r.idoperacion
        LEFT JOIN
    usrcambios u ON g.NumEmpleado = u.NumEmpleado
WHERE
    g.idoperacion = $idoperacion
GROUP BY g.idgruposupervision
";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="GSupervision.php">Grupos de Supervision</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i>Grupos de Supervision</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <tr>
						  	  	<th colspan="5" style="text-align:left">Agregar Grupo <a href="faGSupervision.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>	
							  <tr>
								  <th>No. Grupo</th>
								  <th>Supervisor</th>
								    <th>Rutas Asignadas</th>
								  <th>Acciones</th> 
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{?>
								<tr>
									<td class="center"><?php echo $row['numgrupo']?></td>
									<td class="center"><?php echo $row['nombre']?></td>
									<td class="center"><?php echo $row['rutas']?></td>									
									<td class="center">
										<a class="btn btn-info" href="fmGSupervision.php?id=<?php echo $row['idgruposupervision']; ?>">
											<i class="icon-edit icon-white"></i>  
											Editar                                           
										</a>
										<!--<a class="btn btn-danger" href="dGSupervision.php?id=<?php echo $row['idgruposupervision']; ?>">
											<i class="icon-trash icon-white"></i> 
											Eliminar
										</a>-->
									</td>
								</tr>
							<?php }while($row = $db->fetch_assoc($resultado)); ?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->   
<?php include('footer.php'); ?>
