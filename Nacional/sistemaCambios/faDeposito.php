<?php include('header.php'); 

$consulta = "SELECT idZona, zona FROM zona";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="depositos.php">Depositos</a><span class="divider">/</span>
					</li>
					<li>
						<a href="faDeposito.php">Agregar Depositos</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Agregar Depositos</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="gDeposito.php" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Zona</label>
								<div class="controls">
									<select id="idZ" name="idZ" data-validation-engine="validate[required]">
										<option value="">Selecciona una Zona</option>
										<?php do{?>
											<option value="<?php echo $row['idZona'] ?>"><?php echo $row['zona']; ?></option>
										<?php 
										   }while($row = $db->fetch_assoc($resultado));	
										?>
									</select>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Número de Deposito</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required,custom[number]]" name="ndeposito" id="ndeposito" type="text">
								</div>
							  </div>		
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Deposito</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required]" name="deposito" id="deposito" type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Latitud</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required,custom[number]]" name="latitud" id="latitud" type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Longitud</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required,custom[number]]" name="longitud" id="longitud" type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Gerente</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required]" name="gerente" id="gerente" type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Correo Gerente</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required,custom[email]]" name="cgerente" id="cgerente" type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Jefe de Entrega</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required]" name="jefe" id="jefe" type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Correo Jefe de Entrega</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required,custom[email]]" name="cjefe" id="cjefe" type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Operador</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required]" name="operador" id="operador" type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Correo Operador</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required,custom[email]]" name="coperador" id="coperador" type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Teléfono</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required,custom[phone]]" name="tel" id="tel" type="text">
								</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Estatus</label>
							  	<div class="controls"> 
							  		<select id="estatusr" name="estatusr">
							  			<option value="1" selected = "selected"> Activo </option>
							  			<option value="0"> Inactivo</option>
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
