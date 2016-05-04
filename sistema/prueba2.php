<table class="table table-striped table-bordered bootstrap-datatable datable">
				<thead>
					<tr>
						<th>Deposito</th>
						<th>Fecha</th>
						<th>Tiempo Excedido</th>
						<th>Cola de Espera</th>
						<th>Diseño</th>
						<th>Inicio</th>
						<th>Fin</th>
						<th>Observaciones</th>
						<th>Acciones</th>
					</tr>
				</thead>   
				<tbody>
					<?php 
					if($numRows>0)
					{ 
						//echo 'entro a if';
						do{
							$fecha = $row2['fecha'];
					?>
							<tr>
								<td class="center"><?php echo $row['deposito'];?></td>
								<td class="center"><?php echo $row2['fecha'];?></td>
								<td class="center"><?php echo $row2['tiempoExcedido'];?></td>
								<td class="center"><?php echo $row2['colaEspera'];?></td>
								<td class="center"><?php echo $row2['disenio'];?></td>
								<td class="center"><?php echo $row2['inicio'];?></td>
								<td class="center"><?php echo $row2['fin'];?></td>
								<td class="center"><?php echo $row2['Observaciones'];?></td>
								<td class="center">
									<a class="btn btn-success" href="#">
										<i class="icon-zoom-in icon-white"></i>  
										View                                            
									</a>
									<a class="btn btn-info" href="#">
										<i class="icon-edit icon-white"></i>  
										Edit                                            
									</a>
									<a class="btn btn-danger" href="#">
										<i class="icon-trash icon-white"></i> 
										Delete
									</a>
								</td>
							</tr>
					<?php 
						}while($row2 = $db->fetch_assoc($resultado2));
					}
					if($diferencia>0)
					{
						// si aún no hay ningún registro capturado de la semana elegida se obtiene la fecha del día lunes
						if($diferencia==6){

							$fecha = $fn->getDiasEnSemana($nSemana);
							$nuevaFecha = $fecha[0];
						}

						for($x=0;$x<$diferencia;$x++)
						{
							
					?>
							<tr>
								<td><?php echo $row['deposito'];?></td>
								<td class="center"><?php echo $nuevaFecha;?></td>
								<td class="center">Member</td>
								<td class="center">Hssss</td>
								<td class="center">Hssss</td>
								<td class="center">Hssss</td>
								<td class="center">Hssss</td>
								<td class="center">Hssss</td>
								<td class="center">
									<a class="btn btn-success" href="#">
										<i class="icon-zoom-in icon-white"></i>  
										View                                            
									</a>
									<a class="btn btn-info" href="#">
										<i class="icon-edit icon-white"></i>  
										Edit                                            
									</a>
									<a class="btn btn-danger" href="#">
										<i class="icon-trash icon-white"></i> 
										Delete
									</a>
								</td>
							</tr>
					<?php
							$nuevaFecha = strtotime('+1 day', strtotime($nuevaFecha));

							$nuevaFecha = date('Y-m-d',$nuevaFecha);
						} // fin de for
					} // fin de if
					?>
				</tbody>
			</table>