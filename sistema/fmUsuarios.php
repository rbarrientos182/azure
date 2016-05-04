<?php include('header.php'); 

$idUsuarios = $_GET['id'];

$consulta2 = "SELECT  usuario, clave, nombre, puesto, correo, estatus FROM Usuarios WHERE idUsuarios = $idUsuarios";
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
						<a href="fmUsuarios.php?id=<?php echo $idUsuarios;?>">Modificar Usuarios</a>
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
							  	<label class="control-label" for="focusedInput">Nombre de Usuario</label>
							  	<div class="controls">
							  		<input id="idUsuarios" name="idUsuarios" type="hidden" value="<?php echo $idUsuarios;?>">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" name="usuario" id="usuario" type="text" value="<?php echo $row2['usuario'];?>" readonly></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Contraseña</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" name="pass" id="pass" type="password" value="<?php echo $row2['clave'];?>"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Nombre</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" name="nombre" id="nombre" type="text" value="<?php echo $row2['nombre'];?>"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Puesto</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" name="puesto" id="puesto" type="text" value="<?php echo $row2['puesto'];?>"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Correo</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[custom[email]]" name="email" id="email" type="text" value="<?php echo $row2['correo'];?>"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Estatus</label>
							  	<div class="controls">
							  		<select id="estatus" name="estatus">
							  			<option value="0" <?php if($row2['estatus']==0){ echo 'selected'; }?>>Inactivo</option>
							  			<option value="1" <?php if($row2['estatus']==1){ echo 'selected'; }?>>Activo</option>
							  		</select>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Teléfono</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[custom[onlyNumberSp]]" name="tel" id="tel" type="text" value="<?php echo $row2['telefono'];?>"></input>
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
