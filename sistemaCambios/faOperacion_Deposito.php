<?php include('header.php'); 

$consulta = "SELECT idUsuarios, usuario FROM usuarios";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

$consulta2 = "SELECT idDeposito, deposito FROM deposito";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="operaciones.php">Operaciones</a><span class="divider">/</span>
					</li>
					<li>
						<a href="faOperacion.php">Agregar Operación</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Agregar Operación</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="gOperacion_Depsito.php" method="post">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="focusedInput">Usuario</label>
									<div class="controls">
										<select id="idU" name="idU">
											<option value="">Selecciona un Usuario</option>
											<?php 
												do{?>
													<option value="<?php echo $row['idUsuarios'] ?>"><?php echo $row['usuario']; ?></option>
												<?php 
										   		}while($row = $db->fetch_assoc($resultado));	
												?>
										</select>
									</div>
							  	</div>
							  	<div class="control-group">
									<label class="control-label" for="focusedInput">Deposito</label>
									<div class="controls">
										<select id="idD" name="idD">
											<option value="">Selecciona un Deposito</option>
											<?php do{?>
											<option value="<?php echo $row2['idDeposito'] ?>"><?php echo $row2['deposito']; ?></option>
											<?php 
										   	}while($row2 = $db->fetch_assoc($resultado2));	
											?>
										</select>
									</div>
							  	</div>
							  	<div class="control-group">
							  		<label class="control-label" for="focusedInput">Tipo</label>
							  		<div class="controls">
							  			<select class="input-xlarge focused" id="tipo" name="tipo">
							  				<option value="0">Despacho Dinamico</option>
							  				<option value="1">Pepsi Express</option>
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
