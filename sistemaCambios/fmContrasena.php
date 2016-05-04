<?php include('header.php'); 

$idoperacion = $_SESSION['idoperacion'];
$NumEmpleado = $_SESSION['NumEmpleado'];

$consulta = "SELECT  NumEmpleado, Nombre,Psw, nivel, PPP FROM UsrCambios WHERE NumEmpleado = $NumEmpleado";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="fmUsuarios.php?id=<?php echo $NumEmpleado;?>">Modificar Contraseña</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Contraseña</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mContrasena.php" method="post">
							<fieldset>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">PSW</label>
							  	<div class="controls">
							  		<input type="hidden" name="noemp" id="noemp" value="<?php echo $NumEmpleado;?>">
							  		<input class="input-xlarge focused"  name="pass" id="pass" type="password" data-validation-engine="validate[required,minSize[8]]" value="<?php echo $row['Psw'];?>"></input>
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
