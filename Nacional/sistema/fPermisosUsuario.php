<?php include('header.php');

$idUsuarios = $_GET['id'];

/** consulta para obtener el usuario**/

$consulta = "SELECT u.usuario, u.nombre FROM Usuarios u WHERE u.idUsuarios = ".$idUsuarios." LIMIT 1";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado); 


$consulta2 = "SELECT o.idoperacion, CONCAT(d.deposito,'-',IF(o.mercado,'Moderno','Tradicional')) AS tOperacion FROM Operaciones o
INNER JOIN Deposito d ON o.idDeposito = d.idDeposito";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);

?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="usuarios.php">Usuarios</a><span class="divider">/</span>
					</li>
					<li>
						<a href="fPermisosUsuario.php?id=<?php echo $idUsuarios;?>">Agregar Permisos Usuarios</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Agregar Permisos Usuarios</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mPermisos.php" method="post">
							<fieldset>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Nombre de Usuario</label>
							  	<div class="controls">
							  		<input type="hidden" id="idUsuarios" name="idUsuarios" value="<?php echo $idUsuarios;?>">
							  		<input class="input-xlarge focused" name="usuario" id="usuario" value="<?php echo $row['usuario'];?>" type="text" readonly></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Nombre</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" name="pass" id="pass" value="<?php echo $row['nombre'];?>" type="text" readonly></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Permisos</label>
							  	<div class="controls">
							  		<select class="input-xlarge focused" data-validation-engine="validate[required]" name="operaciones[]" id="operaciones" multiple data-rel="chosen">
							  			<?php 
							  				do{

							  					$consulta3 = "SELECT idoperacion FROM Permisos WHERE idUsuarios = ".$idUsuarios." AND idoperacion = ".$row2['idoperacion'];
							  					$resultado3 = $db->consulta($consulta3);
							  					$row3 = $db->fetch_assoc($resultado3);
							  			?>
							  					<option value="<?php echo $row2['idoperacion'] ?>" <?php if($row2['idoperacion']==$row3['idoperacion']) { echo 'selected';}?>><?php echo $row2['tOperacion'];?></option>
							  			<?php 
							  				}while($row2 = $db->fetch_assoc($resultado2));
							  			?>
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
