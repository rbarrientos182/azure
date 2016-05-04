<?php include('header.php'); 

$id = $_GET['id'];

$consulta = "SELECT idZona, zona FROM zona";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);


$consulta2 = "SELECT idDeposito,idZona,deposito,latitud,longitud,gerenteDeposito,jefeEntrega,operadorSistema,telefonoExt,
						  correoGD, correoJE,correoOP,estatus FROM Deposito WHERE idDeposito = $id LIMIT 1";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);
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
						<a href="fmDeposito.php?id=<?php echo $id; ?>">Editar Depositos</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Depositos</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mDeposito.php" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Zona</label>
								<input type="hidden" name="idDeposito" id="idDeposito" value="<?php echo $id;?>">
								<div class="controls">
									<select id="idZ" name="idZ" disabled>
										<option value="">Selecciona una Zona</option>
										<?php do{?>
											<option value="<?php echo $row['idZona'] ?>" <?php if($row['idZona']==$row2['idZona']){ echo "selected = 'selected'";}?>><?php echo $row['zona']; ?></option>
										<?php 
										   }while($row = $db->fetch_assoc($resultado));	
										?>
									</select>
								</div>
							  </div>		
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Deposito</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required]" name="deposito" id="deposito" type="text" value="<?php echo $row2['deposito'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Latitud</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="latitud" id="latitud" data-validation-engine="validate[required,custom[number]]" type="text" value="<?php echo $row2['latitud'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Longitud</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="longitud" id="longitud" data-validation-engine="validate[required,custom[number]]" type="text" value="<?php echo $row2['longitud'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Gerente</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="gerente" id="gerente" data-validation-engine="validate[required]" type="text" value="<?php echo $row2['gerenteDeposito'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Correo Gerente</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="cgerente" id="cgerente" data-validation-engine="validate[required,custom[email]]" type="text" value="<?php echo $row2['correoGD'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Jefe de Entrega</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="jefe" id="jefe" type="text" data-validation-engine="validate[required]" value="<?php echo $row2['jefeEntrega'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Correo Jefe de Entrega</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="cjefe" id="cjefe" type="text" data-validation-engine="validate[required,custom[email]]" value="<?php echo $row2['correoJE'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Operador</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="operador" id="operador" data-validation-engine="validate[required]" type="text" value="<?php echo $row2['operadorSistema'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Correo Operador</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="coperador" id="coperador" data-validation-engine="validate[required,custom[email]]" type="text" value="<?php echo $row2['correoOP']; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Teléfono</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="tel" id="tel" data-validation-engine="validate[required,custom[phone]]" type="text" value="<?php echo $row2['telefonoExt'];?>">
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
