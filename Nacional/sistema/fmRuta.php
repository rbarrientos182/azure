<?php include('header.php'); 

$id = $_GET['id'];
$id2 = $_GET['id2'];

$consulta = "SELECT  r.Zona, r.Marca, r.NumeroEconomico, r.Odometro, u.idUnidades, r.estatus, u.Tipo, CONCAT(d.deposito,IF(o.mercado,'Moderno','Tradicional')) AS depositom 
             FROM Ruta r INNER JOIN Unidades u ON r.idUnidades = u.idUnidades INNER JOIN Operaciones o ON o.idoperacion = r.idoperacion INNER JOIN  Deposito d ON o.idDeposito = d.idDeposito WHERE r.idRuta = ".$id." AND r.idoperacion = ".$id2." LIMIT 1"; 
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

$consulta2 = "SELECT  idUnidades, CASE tipo WHEN 1 THEN 'Camión' WHEN 2 THEN 'Camioneta' WHEN 3 THEN 'Moto' WHEN 4 THEN 'Diablo' WHEN 5 THEN 'Otros' END AS tipou, CONCAT('P',palets,'/',CASE TipoDePalet WHEN 0 THEN 'Estándar' WHEN 1 THEN 'Otro' END,'/',capacidad)  AS tpalet FROM Unidades";
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
						<a href="fmRuta.php?id=<?php echo $id?>&id2=<?php echo $id2;?>">Modificar Rutas</a>
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
								<label class="control-label" for="focusedInput">Deposito Mercado</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="dMercado" id="dMercado" value="<?php echo $row['depositom'];?>" readonly type="text">
								  <input type="hidden" id="idRuta" name="idRuta" value="<?php echo $id;?>">
								  <input type="hidden" id="idOperacion" name="idOperacion" value="<?php echo $id2;?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">No. Ruta</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="ruta" id="ruta" value="<?php echo $id;?>" readonly type="text">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Tipo Unidad</label>
								<div class="controls">
								  <select id="idUnidades" name="idUnidades">
								  	<?php do{?>
								  		<option value="<?php echo $row2['idUnidades']?>" <?php if($row2['idUnidades']==$row['idUnidades']) { echo 'selected';}?>><?php echo $row2['tipou'].'/'.$row2['tpalet'];?></option>
								  	<?php }while($row2 = $db->fetch_assoc($resultado2));?>
								  </select>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Zona</label>
								<div class="controls">
								  <input class="input-xlarge focused" name="zona" id="zona" type="text" value="<?php echo $row['Zona'];?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Marca</label>
								<div class="controls">
								  <input class="input-xlarge focused"  name="marca" id="marca" type="text" value="<?php echo $row['Marca'];?>" >
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Número Económico</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[custom[number]]" name="nEconomico" id="nEconomico" type="text" value="<?php echo $row['NumeroEconomico'];?>" >
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Odómetro</label>
								<div class="controls">
								  <input class="input-xlarge focused" data-validation-engine="validate[custom[number]]" name="odometro" id="odometro" type="text" value="<?php echo $row['Odometro'];?>">
								</div>
							  </div>
							  <!--<div class="control-group">
								<label class="control-label" for="focusedInput">Estatus</label>
								<div class="controls">
								  <select id="estatus" name="estatus">
								  	<option value="0" <?php //if($row['estatus']==0) { echo 'selected';}?>>Inactivo</option>
								  	<option value="1" <?php //if($row['estatus']==1) { echo 'selected';}?>>Activo</option>
								  	<option value="2" <?php //if($row['estatus']==2) { echo 'selected';}?>>Temporal</option>
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
