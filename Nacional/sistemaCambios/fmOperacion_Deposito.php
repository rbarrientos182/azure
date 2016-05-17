<?php include('header.php'); 
$id = $_GET['id'];
$consulta = "select usuario, deposito, operaciones.nombre from usuarios inner join operaciones_has_deposito on usuarios.idusuarios = operaciones_has_deposito.idusuarios inner join deposito on operaciones_has_deposito.iddeposito = deposito.iddeposito inner join operaciones on operaciones_has_deposito.idoperaciones = operaciones.idoperaciones WHERE idOperaciones_has_deposito = $id";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="operaciones_deposito.php">Operacione Deposito</a><span class="divider">/</span>
					</li>
					<li>
						<a href="fmOperacion_deposito.php?id=<?php echo $id; ?>">Modificar Operación</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Operación</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mOperacion.php" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Nombre</label>
								<div class="controls">
									<input class="input-xlarge focused" data-validation-engine="validate[required]" name="nombre" id="nombre" type="text" value="<?php echo $row['nombre']; ?>">
								</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Tipo</label>
							  	<div class="controls">
							  		<input type="hidden" id="id" name="id" value="<?php echo $id; ?>"> 
							  		<select class="input-xlarge focused" id="tipo" name="tipo">
							  			<option value="0" <?php if($row['tipo']==0) { echo "selected"; } ?>>Despacho Dinámico</option>
							  			<option value="1" <?php if($row['tipo']==1) { echo "selected"; } ?>>Pepsi Exprés</option>
							  		</select>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Estatus</label>
							  	<div class="controls">
							  		<select class="input-xlarge focused" id="estatus" name="estatus">
							  			<option value="0" <?php if($row['estatus']==0) { echo "selected"; } ?>>Inactivo</option>
							  			<option value="1" <?php if($row['estatus']==1) { echo "selected"; } ?>>Activo</option>
							  		</select>
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
