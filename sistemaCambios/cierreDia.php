<?php include('header.php'); 
$idoperacion = $_SESSION['idoperacion'];

$consulta = "SELECT 
    *
FROM
    capturacambios cap
        INNER JOIN
    operaciones ope ON cap.idoperacion = ope.idoperacion
        INNER JOIN
    clientes cte ON ope.iddeposito = cte.iddeposito
        AND cte.nud = cap.nud
        INNER JOIN
    rutascambios ru ON cte.ppp = ru.ruta
        AND cap.idoperacion = ru.idoperacion
WHERE
    cap.idoperacion = $idoperacion AND ru.tipo = 1
       AND ISNULL(cap.estatusdis)
       GROUP BY cap.FechaCambio ORDER BY cap.FechaCambio DESC";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>           
       <div class="box span12">
			<div class="box-content">
					<p><?php //echo $row['nombre']; ?></p>
				    <div class="clearfix"></div>
			</div>

        </div>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="cierreDia.php">Cierre de Día</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i>Cierre de Día</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Fecha Preventa</th>
								  <!--<th>Estatus</th>-->
								  <th>Acción</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{?>
								<tr>
									<td class="center"><?php echo $row['FechaCambio']?></td>
									<!--<td class="center"><?php echo $row['Nombre'];?></td>-->
									<td class="center">
										<a class="btn btn-info" href="#" onclick="cerrarDia('<?php echo $row['FechaCambio'];?>')">
											<i class="icon icon-white icon-locked"></i>  
											Cerrar                                         
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
