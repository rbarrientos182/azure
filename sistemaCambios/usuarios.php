<?php include('header.php'); 
$idoperacion = $_SESSION['idoperacion'];
$NumEmpleado= $_SESSION['NumEmpleado'];

// si el usuario que entro es supervisor unicamente muestro los usuarios de nivel promotor de su grupo de supervision
if($nivel==1){
	$consulta = "SELECT 
    usc.NumEmpleado,
    Nombre,
    nivel,
    CASE (nivel)
        WHEN 1 THEN 'Supervisor'
        WHEN 2 THEN 'Promotor'
        WHEN 3 THEN 'Consulta'
        WHEN 4 THEN 'Administrador'
    END AS tnivel,
    PPP
FROM
    UsrCambios usc
        INNER JOIN
    (SELECT 
        usr.idoperacion, ruta
    FROM
        UsrCambios usr
    INNER JOIN gruposupervision gp ON usr.NumEmpleado = gp.NumEmpleado
    INNER JOIN rutascambios ru ON gp.idgruposupervision = ru.idgruposupervision
    WHERE
        usr.NumEmpleado = $NumEmpleado
        AND usr.idoperacion = $idoperacion) r ON usc.ppp = r.ruta
        AND usc.idoperacion = r.idoperacion
        AND estatus=1";
}
else if($nivel==4){
	$consulta = "SELECT NumEmpleado, Nombre,  nivel, CASE(nivel) WHEN 1 THEN 'Supervisor' WHEN 2 THEN 'Promotor' WHEN 3 THEN 'Consulta' WHEN 4 THEN 'Administrador' END  AS tnivel,PPP FROM UsrCambios WHERE idoperacion = $idoperacion AND estatus=1";	
}
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>           
       <div class="box span12">
			<div class="box-content">
					<p><?php echo $row['nombre']; ?></p>
				    <div class="clearfix"></div>
			</div>

        </div>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="usuarios.php">Usuarios</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i>Usuarios</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <tr>
						  	  	<th colspan="5" style="text-align:left">Agregar Usuarios <a href="faUsuarios.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>	
							  <tr>
								  <th>No. de Empleado</th>
								  <th>Nombre</th>
								  <!--<th>Usuario</th>-->
								  <th>Nivel</th>
								  <th>PPP</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php do{?>
								<tr>
									<td class="center"><?php echo $row['NumEmpleado']?></td>
									<td class="center"><?php echo $row['Nombre'];?></td>
									<!--<td class="center"><?php echo $row['Usuario'];?></td>-->
									<td class="center"><?php echo $row['tnivel'];?></td>
									<td class="center"><?php echo $row['PPP'];?></td>
									<td class="center">
										<a class="btn btn-info" href="fmUsuarios.php?id=<?php echo $row['NumEmpleado']; ?>">
											<i class="icon-edit icon-white"></i>  
											Editar                                           
										</a>
										<!--<a class="btn btn-danger" href="dUsuarios.php?id=<?php echo $row['NumEmpleado']; ?>">
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
