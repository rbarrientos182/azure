<?php include('header.php'); 

$id = $_GET['id'];

$idoperacion = $_SESSION['idoperacion'];

$consulta = "SELECT ruta, tipo, estatus, tMercado, idgruposupervision FROM rutasCambios WHERE idrutasCambios = $id LIMIT 1"; 
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);


$consulta2 = "SELECT idgruposupervision, numgrupo FROM gruposupervision WHERE idoperacion = $idoperacion";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);
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
						<a href="fmRuta.php?id=<?php echo $id?>">Modificar Rutas</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Rutas</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mRuta.php" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">No. Ruta</label>
								<div class="controls">
									<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
								  	<input class="input-xlarge focused" name="ruta" id="ruta" value="<?php echo $row['ruta'];?>" readonly type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Tipo</label>
								<div class="controls">
								  <select id="tipoR" name="tipoR">
								  	<option value="2" <?php if($row['tipo']==2) { echo 'selected';}?>>Dinámico</option>
								  	<option value="1" <?php if($row['tipo']==1) { echo 'selected';}?>>Fijo</option>
								  </select>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Mercado</label>
								<div class="controls">
								  <select id="tipoM" name="tipoM">
								  	<option value="0" <?php if($row['tMercado']==0) { echo 'selected';}?>>Tradicional</option>
								  	<option value="1" <?php if($row['tMercado']==1) { echo 'selected';}?>>Moderno</option>
								  	<option value="2" <?php if($row['tMercado']==2) { echo 'selected';}?>>Híbrido</option>
								  </select>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Estatus</label>
								<div class="controls">
								  <select id="estatusR" name="estatusR">
								  	<option value="1" <?php if($row['estatus']==1) { echo 'selected';}?>>Habilitado</option>
								  	<option value="0" <?php if($row['estatus']==0) { echo 'selected';}?>>Inhabilitado</option>
								  </select>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">No. Grupo</label>
								<div class="controls">
								  <select id="nGrupo" name="nGrupo">
								  	<?php do{?>
								  		<option value="<?php echo $row2['idgruposupervision'];?>" <?php if($row2['idgruposupervision']==$row['idgruposupervision']) { echo 'selected';}?>><?php echo $row2['numgrupo'];?></option>
								  	<?php }while($row2 = $db->fetch_assoc($resultado2));?>
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
