<?php include('header.php'); 
$consulta = "select idcontrol, usuario, deposito, idOperaciones from usuarios inner join operaciones_has_deposito on usuarios.idusuarios = operaciones_has_deposito.idusuarios inner join deposito on operaciones_has_deposito.idDeposito = deposito.iddeposito";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="operaciones_deposito.php">Operaciones Deposito</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i>Operaciones</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <tr>
						  	  	<th colspan="4" style="text-align:left">Agregar Operación <a href="faOperacion_Deposito.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>
							  <tr>
								  <th>Usuario</th>
								  <th>Deposito</th>
								  <th>Tipo de Mercado</th>
								  <th>Accion</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{ ?>
							<tr>
								<td class="center"><?php echo $row['usuario'];?></td>
								<td class="center"><?php echo $row['deposito']; ?></td>
								<td class="center"><?php if ($row['idOperaciones']==0) { echo "Despacho Dinamico";} else { echo "Pepsi Express";}?> </td>
								<td class="center">
									<!--<a class="btn btn-info" href="fmOperacion_Deposito.php?id=<?php echo $row['idOperaciones_deposito'];?>">
										<i class="icon-edit icon-white"></i>  
										Editar                                            
									</a>-->
									<a class="btn btn-danger" href="Eoperacion_deposito.php?id=<?php echo $row['idcontrol']?>">
										<i class="icon-trash icon-white"></i> 
										Borrar
									</a>
								</td>
							</tr>
							<?php  }while($row = $db->fetch_assoc($resultado));?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

			
    
<?php include('footer.php'); ?>

