<?php include('header.php'); 

$idCambiosMotivos = $_GET['id'];

$consulta = "SELECT  Descripcion FROM CambiosMotivos WHERE idCambiosMotivos = $idCambiosMotivos";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="Motivos.php">Motivos</a><span class="divider">/</span>
					</li>
					<li>
						<a href="fmMotivos.php?id=<?php echo $idCambiosMotivos;?>">Modificar Motivos</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Motivos</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mMotivos.php" method="post">
							<fieldset>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Descripción</label>
							  	<div class="controls">
							  		<input type="text" class="input-xlarge focused" data-validation-engine="validate[required]" name="Des" id="Des" type="text" value="<?php echo $row['Descripcion'];?>" ></input>
							  		<input type="hidden" name="id" id="id" value="<?php echo $idCambiosMotivos;?>"></input>
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
