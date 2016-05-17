<?php include('header.php'); 

$NumEmpleado = $_GET['id'];
$idoperacion = $_SESSION['idoperacion'];

$consulta = "SELECT  NumEmpleado, Nombre,Psw, nivel, PPP FROM UsrCambios WHERE NumEmpleado = $NumEmpleado";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

$consulta2 = "SELECT ruta, idrutascambios FROM rutascambios WHERE idoperacion = $idoperacion";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="usuarios.php">Usuarios</a><span class="divider">/</span>
					</li>
					<li>
						<a href="fmUsuarios.php?id=<?php echo $NumEmpleado;?>">Modificar Usuarios</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Usuarios</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mUsuario.php" method="post">
							<fieldset>
							  <div class="control-group">
							  	
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">No. Empleado</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required,custom[onlyNumberSp]]" name="noemp" id="noemp" type="text" value="<?php echo $row['NumEmpleado'];?>" readonly></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Nombre</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" name="nombre" id="nombre" type="text" value="<?php echo $row['Nombre'];?>"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Nivel</label>
							  	<div class="controls">
							  		<select id="nivel" name="nivel">
							  			<?php if($nivel==4){ ?>
								  			<option value="1" <?php if($row['nivel']==1){ echo 'selected'; }?>>Supervisor</option>
							  				<option value="3" <?php if($row['nivel']==3){ echo 'selected'; }?>>Consulta</option>
							  			<?php }?>
							  			<option value="2" <?php if($row['nivel']==2){ echo 'selected'; }?>>Promotor</option>
							  		</select>
							  	</div>
							  </div>

							   <div class="control-group">
							  	<label class="control-label" for="focusedInput">Ruta</label>
							  	<div class="controls">
							  		<select id="ppp" name="ppp" data-rel="chosen" data-validation-engine="validate[required]">
							  		<option value="<?php echo $row['PPP'];?>"><?php echo $row['PPP'];?> </option>
										<?php do{?>
											<option value="<?php echo $row2['ruta'];?>"><?php echo $row2['ruta'];?> </option>
										<?php 
										}while($row2 = $db->fetch_assoc($resultado2));	
										?>
									</select>
							  	</div>
							  </div>

							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">PSW</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused"  name="pass" id="pass" type="password" data-validation-engine="validate[required,minSize[8]]" value="<?php echo $row['Psw'];?>"></input>
							  	</div>
							  </div>
							  <div class="form-actions">
							  	<button type="submit" id="btn_Guardar" name="btn_Guardar" class="btn btn-primary">Guardar</button>
							  	<button type="reset" class="btn">Cancelar</button>
							  </div>	
							</fieldset>
						</form>
					</div>
				</div><!--/span-->			
			</div><!--/row-->
<?php include('footer.php'); ?>
