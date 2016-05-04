<?php 
require_once('clases/class.MySQL.php');
$no_visible_elements=true;
$db = new MySQL();
$idDeposito = $_POST['idDeposito'];
$idRuta = $_POST['idRuta'];

$consulta =  "SELECT CONCAT(d.idDeposito,'-',d.deposito) AS depo, c.nud, c.nombre, c.municipio, c.direccion, CONCAT(c.calleizq,' y ',c.calleder) AS cruce, vpp, ppp
			  FROM deposito D INNER JOIN operaciones O ON D.iddeposito=O.iddeposito INNER JOIN ruta r On o.idoperacion = r.idoperacion INNER JOIN clientes c ON o.iddeposito=c.iddeposito
			  WHERE c.vpp=r.idruta AND  c.idDeposito = ".$idDeposito." AND c.vpp = ".$idRuta." ORDER BY nombre";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div id="dTablaClientes" class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	 <!--<tr>
						  	  	<th colspan="4" style="text-align:left">Agregar Cliente <a href="faCliente.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>-->
							  <tr>
								  <th>Nud</th>
								  <th>Cliente</th>
								  <th>Municipio</th>
								  <th>Dirección</th>
								  <th>Cruce</th>
								  <th>Ruta Preventa</th>
								  <th>Ruta Entrega</th>
								  <!--<th>Acciones</th>-->
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php 
						  		do{
						  	?>
								<tr>
									<td><?php echo $row['nud'];?></td>
									<td class="center"><?php echo utf8_encode($row['nombre']);?></td>
									<td class="center"><?php echo utf8_encode($row['municipio']);?></td>
									<td class="center"><?php echo utf8_encode($row['direccion']);?></td>
									<td class="center"><?php echo utf8_encode($row['cruce']);?></td>
									<td class="center"><?php echo $row['ppp'];?></td>
									<td class="center"><?php echo $row['vpp'];?></td>
									<!--<td class="center">
										<a class="btn btn-success" href="#">
											<i class="icon-zoom-in icon-white"></i>  
											Detalles                                            
										</a>
										<a class="btn btn-info" href="#">
											<i class="icon-edit icon-white"></i>  
											Editar                                           
										</a>
										<a class="btn btn-danger" href="#">
											<i class="icon-trash icon-white"></i> 
											Borrar
										</a>
									</td>-->
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
