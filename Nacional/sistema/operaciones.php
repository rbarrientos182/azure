<?php include('header.php'); 
$consulta = "SELECT o.idoperacion, o.idDeposito, o.mercado, o.coordinador_despacho, IF(o.mercado,'Moderno','Tradicional') AS tMercado, d.deposito  FROM Operaciones o INNER JOIN  Deposito d 
ON o.idDeposito = d.idDeposito";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="operaciones.php">Operaciones</a>
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
						  	  	<th colspan="2" style="text-align:left">Agregar Operación <a href="faOperacion.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>
							  <tr>
								  <th>Deposito</th>
								  <th>Tipo de Mercado</th>
								  <th>Coordinador Despacho D.</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{ ?>
							<tr>
								<td class="center"><?php echo $row['deposito'];?></td>
								<td><?php echo $row['tMercado']?></td>
								<td><?php echo $row['coordinador_despacho']?></td>
								<td class="center">
									<a class="btn btn-info" href="fmOperacion.php?id=<?php echo $row['idoperacion'];?>&id2=<?php echo $row['mercado'];?>">
										<i class="icon-edit icon-white"></i>  
										Editar                                            
									</a>
								<!--	<a class="btn btn-danger" href="dOperacion.php?id=<?php echo $row['idOperaciones'];?>">
										<i class="icon-trash icon-white"></i> 
										Borrar
									</a>
								</td>-->
							</tr>
							<?php  }while($row = $db->fetch_assoc($resultado));?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

			
    
<?php include('footer.php'); ?>
