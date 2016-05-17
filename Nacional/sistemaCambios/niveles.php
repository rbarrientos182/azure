<?php include('header.php'); 
$consulta = "SELECT idNivel, nivel, descripcion FROM Nivel";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="niveles.php">Niveles</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i> Niveles</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <tr>
						  	  	<th colspan="4" style="text-align:left">Agregar Nivel <a href="faNivel.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>
							  <tr>
								  <th>Id Nivel</th>
								  <th>Nivel</th>
								  <!--<th>Estatus</th>-->
								  <th>Descripción</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{ ?>
							<tr>
								<td><?php echo $row['idNivel'];?></td>
								<td class="center"><?php echo $row['nivel'];?></td>
								<!--<td class="center">
									<span class="label <?php echo $row['estatusE'];?>"><?php echo $row['estatuss']; ?></span>
								</td>-->
								<td><?php echo $row['descripcion']?></td>
								<td class="center">
									<a class="btn btn-info" href="fmNivel.php?id=<?php echo $row['idNivel'];?>">
										<i class="icon-edit icon-white"></i>  
										Editar                                            
									</a>
									<!--<a class="btn btn-danger" href="dNivel.php?id=<?php echo $row['idNivel'];?>">
										<i class="icon-trash icon-white"></i> 
										Borrar
									</a>-->
								</td>
							</tr>
							<?php  }while($row = $db->fetch_assoc($resultado));?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

			
    
<?php include('footer.php'); ?>
