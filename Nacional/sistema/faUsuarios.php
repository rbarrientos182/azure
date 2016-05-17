<?php include('header.php'); 

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
						<a href="faUsuarios.php">Agregar Usuarios</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Agregar Usuarios</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="gUsuario.php" method="post">
							<fieldset>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Nombre de Usuario</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" name="usuario" id="usuario" type="text"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Contraseña</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" name="pass" id="pass" type="password"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Nombre</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" name="nombre" id="nombre" type="text"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Puesto</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" name="puesto" id="puesto" type="text"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Correo</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[custom[email]]" name="email" id="email" type="text"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Teléfono</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[custom[onlyNumberSp]]" name="tel" id="tel" type="text"></input>
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
