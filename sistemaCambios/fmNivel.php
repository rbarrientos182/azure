<?php include('header.php'); 
$id = $_GET['id'];

$consulta = "SELECT nivel,descripcion FROM Nivel WHERE idNivel = $id";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="niveles.php">Niveles</a><span class="divider">/</span>
					</li>
					<li>
						<a href="fmNivel.php?id=<?php echo $id;?>">Modificar Niveles</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Niveles</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mNivel.php" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Nivel</label>
								<div class="controls">
								  <input type="hidden" id="idNivel" name="idNivel" value="<?php echo $id;?>">	
								  <input class="input-xlarge focused" data-validation-engine="validate[required]" name="nivel" id="nivel" type="text" value="<?php echo $row['nivel'];?>">
								</div>
							  </div>
							 <div class="control-group">
							  	<label class="control-label" for="focusedInput">Descripción</label>
							  	<div class="controls">
							  		<textarea class="input-xlarge focused" data-validation-engine="validate[required]" name="descripcion" id="descripcion"><?php echo $row['descripcion'];?></textarea>
							  	</div>
							  </div>
							  <!--<div class="control-group">
							  	<label class="control-label" for="focusedInput">Estatus</label>
							  	<div class="controls"> 
							  		<select id="estatusr" name="estatusr">
							  			<option value="1" <?php if($row['estatus']==1){ echo "selected = 'selected' ";}?>> Activo </option>
							  			<option value="0" <?php if($row['estatus']==0){ echo "selected = 'selected' ";} ?>> Inactivo</option>
							  		</select>
							    </div>
							  </div>-->
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
