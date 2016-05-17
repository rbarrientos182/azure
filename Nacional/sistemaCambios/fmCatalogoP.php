<?php include('header.php'); 

$idProductoCambio = $_GET['id'];
$idoperacion = $_GET['id2'];
$sku = $_GET['id3'];

$consulta = "SELECT  pc.sku, p.Descripcion, pc.DescripcionInterna, pc.skuConver FROM ProductosCambios pc 
INNER JOIN Productos p ON pc.sku = p.sku AND pc.idProductoCambio = $idProductoCambio AND pc.idoperacion = $idoperacion AND pc.sku = $sku";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="catalogsP.php">Catálogo Producto</a><span class="divider">/</span>
					</li>
					<li>
						<a href="fmCatalogoP.php?id=<?php echo $idProductoCambio;?>&id2=<?php echo $idoperacion;?>&id3=<?php echo $sku; ?>">Modificar Producto</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Producto</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mCatalogoP.php" method="post">
							<fieldset>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">SKU</label>
							  	<div class="controls">
							  		<input name="id" id="id" type="hidden" value="<?php echo $idProductoCambio?>">
							  		<input name="id2" id="id2" type="hidden" value="<?php echo $idoperacion?>">
							  		<input name="id3" id="id3" type="hidden" value="<?php echo $sku?>">
							  		<input class="input-xlarge focused"  name="sku" id="sku" type="text" value="<?php echo $row['sku'];?>" readonly></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Producto</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" name="des" id="des" type="text" value="<?php echo $row['Descripcion'];?>" readonly></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Descripción Interna</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" name="desi" id="desi" type="text" value="<?php echo $row['DescripcionInterna'];?>"></input>
							  	</div>
							  </div>
							  <?php 
								  	$consulta2 = "SELECT  pc.sku, p.Descripcion FROM ProductosCambios pc INNER JOIN Productos p ON pc.sku = p.sku AND idoperacion = $idoperacion";
									$resultado2 = $db->consulta($consulta2);
									$row2 = $db->fetch_assoc($resultado2);
							   ?>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Producto Conversion</label>
							  	<div class="controls">
							  		<select class="input-xlarge focused" name="skuConver" id="skuConver">
							  			<?php do{?>
							  				<option value="<?php echo $row2['sku']?>" <?php if($row2['sku']==$row['skuConver']){ echo 'selected'; }?>><?php echo $row2['Descripcion']?></option>
							  			<?php }while ($row2 = $db->fetch_assoc($resultado2))
							  					
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
