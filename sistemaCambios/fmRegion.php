<?php include('header.php'); 
$id = $_GET['id'];

$consulta = "SELECT region, director, correo FROM Region WHERE idRegion = $id";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="regiones.php">Regiones</a><span class="divider">/</span>
					</li>
					<li>
						<a href="famegion.php">Modificar Regiones</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Regiones</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mRegion.php" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Región</label>
								<div class="controls">
								  <input type="hidden" id="idRegion" name="idRegion" value="<?php echo $id;?>">	
								  <input class="input-xlarge focused" data-validation-engine="validate[required]" name="region" id="region" type="text" readonly value="<?php echo $row['region'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Director</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required]" name="director" id="director" type="text" value="<?php echo $row['director'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Correo</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required,custom[email]]" name="correo" id="correo" type="text" value="<?php echo $row['correo'];?>">
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
