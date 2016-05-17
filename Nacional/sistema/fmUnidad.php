<?php include('header.php');

$idUnidades = $_GET['id'];

$consulta = "SELECT Tipo, capacidad, palets, TipoDePalet FROM Unidades WHERE idUnidades = ".$idUnidades;
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="unidades.php">Unidades</a><span class="divider">/</span>
					</li>
					<li>
						<a href="faUnidad.php">Agregar Unidad</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Agregar Unidad</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="gUnidad.php" method="post" enctype="multipart/form-data">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Tipo</label>
								<div class="controls">
								    <select name="tipo" id="tipo" data-validation-engine="validate[required]">
									  	<option value="">Selecciona un Tipo</option>
									  	<option value="1" <?php if($row['Tipo']==1){ echo 'selected';}?>>Camión</option>
									  	<option value="2" <?php if($row['Tipo']==2){ echo 'selected';}?>>Camioneta</option>
									  	<option value="3" <?php if($row['Tipo']==3){ echo 'selected';}?>>Moto</option>
									  	<option value="4" <?php if($row['Tipo']==4){ echo 'selected';}?>>Diablo</option>
									  	<option value="5" <?php if($row['Tipo']==5){ echo 'selected';}?>>Otro</option>
								    </select>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Palets</label>
								<div class="controls">
									<select name="palets" id="palets" data-validation-engine="validate[required]">
									  	<option value="">Selecciona Cantidad de Palets</option>
									  	<option value="6" <?php if($row['palets']==6){ echo 'selected';} ?>>6</option>
									  	<option value="10" <?php if($row['palets']==10){ echo 'selected'; }?>>10</option>
								    </select>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Tipo de Palets</label>
								<div class="controls">
									<select name="tpalets" id="tpalets" data-validation-engine="validate[required]">
									  	<option value="">Selecciona Tipo de Palet</option>
									  	<option value="1" <?php if($row['TipoDePalet']==1){ echo 'selected'; } ?>>Estándar</option>
									  	<option value="2" <?php if($row['TipoDePalet']==2){ echo 'selected'; }?>>Otro</option>
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
