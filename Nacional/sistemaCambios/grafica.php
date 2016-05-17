<?php include('header.php'); 

$idoperacion = $_SESSION['idoperacion'];

/**Query del catalogo de usrcambios**/
$consultaU = "SELECT numempleado,nombre FROM usrcambios WHERE idoperacion = $idoperacion AND nivel = 1 ORDER BY nombre";
$resultadoU = $db->consulta($consultaU);
$rowU = $db->fetch_assoc($resultadoU);

/**Query para obtener el segmento de los productos cambios**/
$consultaS = "SELECT 
    segmento
FROM
    productos p
        INNER JOIN
    productoscambios pc ON p.sku = pc.sku AND presentacion != ''
        AND pc.idoperacion = $idoperacion
GROUP BY segmento
ORDER BY segmento";
$resultadoS = $db->consulta($consultaS);
$rowS = $db->fetch_assoc($resultadoS);

/**Query del catalogo de cambiosmotivo**/
$consultaM = "SELECT idCambiosMotivos, Descripcion FROM cambiosmotivos WHERE idoperacion = $idoperacion";
$resultadoM = $db->consulta($consultaM);
$rowM = $db->fetch_assoc($resultadoM);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="consultaReportesIndicadores.php">Indicadores Grafica</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Indicadores Grafica</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>

					<div class="box-content">
						<form class="form-horizontal" id="registro" method="post" action="grafica/graficos.php" target="_blank">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="selectError">De</label>
								<div class="controls">
									<input type="text" class="input-xlarge uneditable-input datepicker" id="fechaDe" name="fechaDe" value="<?php echo date('Y-m-d')?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="selectError">Para</label>
								<div class="controls">
									<input type="text" class="input-xlarge uneditable-input datepicker" id="fechaPara" name="fechaPara" value="<?php echo date('Y-m-d')?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="selectError">JT/Cedis</label>
								<div class="controls">
									<select class="input-xlarge focused" name="jt" id="jt">
								  		<option value="cero">Todos</option>
								  		<?php do{?>
								  			<option value="<?php echo $rowU['numempleado']?>"><?php echo utf8_encode(ucwords(strtolower($rowU['nombre'])));?></option>
								  		<?php }while($rowU = $db->fetch_assoc($resultadoU));?>
								  	</select>
							  	</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="selectError">Segmento</label>
								<div class="controls">
									<select class="input-xlarge focused" name="seg" id="seg">
								  		<option value="0">Todos</option>
								  		<?php do{?>
								  			<option value="<?php echo $rowS['segmento']?>"><?php echo utf8_encode(ucwords(strtolower($rowS['segmento'])));?></option>
								  		<?php }while($rowS = $db->fetch_assoc($resultadoS));?>
								  	</select>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="selectError">Motivos</label>
								<div class="controls">
									<select class="input-xlarge focused" name="mot" id="mot">
								  		<option value="0">Todos</option>
								  		<?php do{?>
								  			<option value="<?php echo $rowM['idCambiosMotivos']?>"><?php echo utf8_encode(ucwords(strtolower($rowM['Descripcion'])));?></option>
								  		<?php }while($rowM = $db->fetch_assoc($resultadoM));?>
								  	</select>
								</div>
							  </div>
							  <div class="form-actions">
								<button type="submit" id="btn_consultaG" name="btn_consultaG" class="btn btn-primary">Consultar</button>
								<button type="reset" class="btn">Cancelar</button>
							  </div>
							</fieldset>
						  </form>
					</div>
					<div class="box-content" id="div_consultaG" name="div_consultaG"></div>
				</div><!--/span-->
					
			</div><!--/row-->
			
<?php include('footer.php'); ?>