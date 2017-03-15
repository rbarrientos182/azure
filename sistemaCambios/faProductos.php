<?php include('header.php');

$idoperacion = $_SESSION['idoperacion'];

/** Query del catalogo de cambios de productos **/
$consulta = "SELECT sku, Descripcion FROM Productos  ORDER BY sku";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

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
						<a href="faProductos.php">Agregar Productos</a>
					</li>
				</ul>
			</div>

			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Agregar Productos</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>

					<div class="box-content">
						<form class="form-horizontal" id="registro" action="gProducto.php" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="selectError">Producto</label>
								<div class="controls">
									<select id="idP" name="idP" data-rel="chosen" data-validation-engine="validate[required]">
										<?php do{?>
											<option value="<?php echo $row['sku']; ?>"><?php echo $row['sku'].' - '.$row['Descripcion']; ?></option>
										<?php
										}while($row = $db->fetch_assoc($resultado));
										?>
									</select>
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Descripcion Interna</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="desIn" name="desIn" data-validation-engine="validate[required]" type="text">
								</div>
							  </div>
							   <div class="control-group">
							  	<label class="control-label" for="focusedInput">Tipo de Mercado</label>
							  	<div class="controls">
							  		<select class="input-xlarge focused" name="Mer" id="Mer" >
							  				<option value="0" selected>Tradicional</option>
							  				<option value="1">Moderno</option>
							  				<option value="2">Híbrido</option>
							  		</select>
							  	</div>
							  </div>
							  <div class="form-actions">
								<button type="submit" id="btn_Guardar" name="btn_Guardar" class="btn btn-primary" >Agregar</button>
								<button type="reset" class="btn">Cancelar</button>
							  </div>
							</fieldset>
						  </form>
					</div>
					<div class="box-content" id="div_motivos" name="div_motivos"></div>
				</div><!--/span-->

			</div><!--/row-->

<?php include('footer.php'); ?>
