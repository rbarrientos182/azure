<?php include('header.php');
	
$idoperacion = $_SESSION['idoperacion'];
$consulta = "SELECT idgruposupervision, numgrupo FROM gruposupervision WHERE idoperacion = $idoperacion";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);	
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="rutas.php">Rutas</a><span class="divider">/</span>
					</li>
					<li>
						<a href="faRuta.php">Agregar Rutas</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Agregar Rutas</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="gRuta.php" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">No. Ruta</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[required,custom[number]]" name="ruta" id="ruta" type="text">
								</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Tipo</label>
							  	<div class="controls"> 
							  		<select id="tipoR" name="tipoR">
							  			<option value="2" selected = "selected">Dinámico </option>
							  			<option value="1">Fijo</option>
							  		</select>
							    </div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Mercado</label>
							  	<div class="controls"> 
							  		<select id="tipoM" name="tipoM">
							  			<option value="0" selected = "selected">Tradicional </option>
							  			<option value="1">Moderno</option>
							  			<option value="2">Híbrido</option>
							  		</select>
							    </div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Estatus</label>
							  	<div class="controls"> 
							  		<select id="estatusR" name="estatusR">
							  			<option value="1" selected = "selected">Habilitado </option>
							  			<option value="0">Inhabilitado</option>
							  		</select>
							    </div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">No. Grupo</label>
							  	<div class="controls"> 
							  		<select id="nGrupo" name="nGrupo">
							  			<?php do{ ?>
							  				<option value="<?php echo $row['idgruposupervision'];?>"><?php echo $row['numgrupo'];?> </option>
							  			<?php }while($row = $db->fetch_assoc($resultado)) ?>
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
