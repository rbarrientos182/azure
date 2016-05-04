<?php include('header.php'); 
$id = $_GET['id'];

$consulta = "SELECT zona, gerenteZona, idRegion FROM Zona WHERE idZona = $id LIMIT 1";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

$consulta2 = "SELECT idRegion, region FROM Region";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="zonas.php">Zonas</a><span class="divider">/</span>
					</li>
					<li>
						<a href="fmZonas.php?id=<?php echo $id?>">Modificar Zonas</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Zonas</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mZona.php" method="post">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="focusedInput">Región</label>
									<div class="controls">
										<input type="hidden" id="idzona" name="idzona" value="<?php echo $id?>">
										<select class="input-xlarge focused" id="idRegion" name="idRegion">
											<?php do{?>
												<option value="<?php echo $row2['idRegion']?>" <?php if($row['idRegion']==$row2['idRegion']){ echo 'selected'; } ?>><?php echo $row2['region'];?></option>
											<?php }while($row2 = $db->fetch_assoc($resultado2))?>
										</select>
									</div>
							  	</div>
							    <div class="control-group">
									<label class="control-label" for="focusedInput">Zona</label>
									<div class="controls">
										<input class="input-xlarge focused" data-validation-engine="validate[required]" name="zona" id="zona" type="text" value="<?php echo $row['zona']?>">
									</div>
							    </div>
							    <div class="control-group">
									<label class="control-label" for="focusedInput">Gerente</label>
									<div class="controls">
										<input class="input-xlarge focused" data-validation-engine="validate[required]" name="gerente" id="gerente" type="text" value="<?php echo $row['gerenteZona']?>">
									</div>
							    </div>
							    <div class="form-actions">
							  		<button type="submit" id="btn_Guardar" name="btn_Guardar" class="btn btn-primary">Guardar</button>
							  		<button type="reset" class="btn">Cancelar</button>
							    </div>	
						  </form>
					</div>
				</div><!--/span-->			
			</div><!--/row-->
<?php include('footer.php'); ?>
