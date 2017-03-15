<?php include('header.php');
$idoperacion = $_SESSION['idoperacion'];
$idProductoCambio = $_GET['id'];
$sku = $_GET['id2'];


/** Query del catalogo de cambios de productos **/
$consulta = "SELECT sku, Descripcion FROM Productos  ORDER BY sku";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

/** Query del catalogo de los productos por CEDIS **/
$consulta2 = "SELECT sku, Descripcion FROM Productos  ORDER BY sku";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);

/** Query para saber el producto falta inner join con grupo supervision**/
$consultaPr = "SELECT  pc.sku,pc.DescripcionInterna, pc.skuConver, pc.tmercado, pc.estatus FROM ProductosCambios pc
INNER JOIN Productos p ON pc.sku = p.sku AND pc.idProductoCambio = $idProductoCambio AND pc.idoperacion = $idoperacion AND pc.sku = $sku";
$resultadoPr = $db->consulta($consultaPr);
$rowPr = $db->fetch_assoc($resultadoPr);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="catalogsP.php">Productos</a><span class="divider">/</span>
					</li>
					<li>
						<a href="fmCatalogoP.php?id=<?php echo $idProductoCambio;?>&id2=<?php echo $sku;?>">Modificar Producto</a>
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
						<form class="form-horizontal" id="registro" action="mProducto.php" method="post">
							<fieldset>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Producto</label>
							  	<div class="controls">
							  		<input name="id" id="id" type="hidden" value="<?php echo $idProductoCambio?>">
							  		<input name="id2" id="id2" type="hidden" value="<?php echo $sku?>">
							  		<select id="idP" name="idP" data-rel="chosen" data-validation-engine="validate[required]" disabled>
										<?php do{?>
											<option value="<?php echo $row['sku']; ?>" <?php if($row['sku']==$rowPr['sku']){ echo "selected = 'selected'";}?>><?php echo $row['sku'].' - '.$row['Descripcion']; ?></option>
										<?php
										}while($row = $db->fetch_assoc($resultado));
										?>
									</select>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Descripción Interna</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" name="desIn" id="desIn" type="text" value="<?php echo $rowPr['DescripcionInterna'];?>"></input>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Tipo de Mercado</label>
							  	<div class="controls">
							  		<select class="input-xlarge focused" name="Mer" id="Mer" >
							  				<option value="0" <?php if($rowPr['tmercado']==0){ echo 'selected';} ?>>Tradicional</option>
							  				<option value="1" <?php if($rowPr['tmercado']==1){ echo 'selected';} ?>>Moderno</option>
							  				<option value="2" <?php if($rowPr['tmercado']==2){ echo 'selected';} ?>>Híbrido</option>
							  		</select>
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Estatus</label>
							  	<div class="controls">
							  		<select class="input-xlarge focused" name="estatus" id="estatus" >
							  				<option value="0" <?php if($rowPr['estatus']==0){echo 'selected';} ?>>Inahabilitado</option>
							  				<option value="1" <?php if($rowPr['estatus']==1){echo 'selected';} ?>>Habilitado</option>
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
