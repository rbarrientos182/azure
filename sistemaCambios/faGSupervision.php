<?php include('header.php');
	
$idoperacion = $_SESSION['idoperacion'];
$consulta = "SELECT 
    numempleado, nombre
FROM
    usrcambios u
WHERE
    asignado = 0 AND nivel = 1
        AND u.idoperacion = $idoperacion";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);	
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="GSupervision.php">Grupos de Supervisión</a><span class="divider">/</span>
					</li>
					<li>
						<a href="faGSupervision.php">Agregar Grupo de Supervisión</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Agregar Grupo de Supervision</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="gGSupervision.php" method="post">
							<fieldset>
							   <div class="control-group">
							  	<label class="control-label" for="focusedInput">No. Grupo</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required,custom[onlyNumberSp]]" name="nGrupo" id="nGrupo" type="text"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Supervisor</label>
							  	<div class="controls"> 
							  		<select id="nEmpleado" name="nEmpleado">
							  			<?php do{ ?>
							  				<option value="<?php echo $row['numempleado'];?>"><?php echo $row['nombre'];?> </option>
							  			<?php }while($row = $db->fetch_assoc($resultado)) ?>
							  		</select>
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
