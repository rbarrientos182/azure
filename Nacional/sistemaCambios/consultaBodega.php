<?php include('header.php'); 

$idoperacion = $_SESSION['idoperacion'];

/** Query del catalogo de cambios de productos **/
$consulta = "SELECT idCambiosMotivos,  Descripcion FROM CambiosMotivos WHERE idoperacion=$idoperacion ORDER BY Descripcion";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

/** Query del catalogo de los productos por CEDIS **/
$consulta2 = "SELECT idProductoCambio,  DescripcionInterna, Descripcion FROM ProductosCambios Pc INNER JOIN Productos  P ON Pc.sku=P.sku WHERE idoperacion=$idoperacion ORDER BY DescripcionInterna";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);


/** Query de clientes dependiendo del deposito a donde corresponde el usuario que se logueo**/
/*$consulta3 = "SELECT  nombre,nud FROM Clientes C INNER JOIN Operaciones O ON C.iddeposito=O.iddeposito WHERE idoperacion=$idoperacion ORDER BY nud";
$resultado3 = $db->consulta($consulta3);
$row3 = $db->fetch_assoc($resultado3);*/
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="AltaMotivos.php">Captura Cambios</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Captura Cambios</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>

					<div class="box-content">
						<form  class="form-horizontal">
							<fieldset>

							  <div class="control-group">
								<label class="control-label" for="selectError">Fecha Preventa</label>
								<div class="controls">
									<input type="text" class="input-xlarge datepicker" id="fechaO" value="<?php echo date('Y-m-d')?>" readonly>
								</div>
							  </div>
							  <!--<div class="control-group">
								<label class="control-label" for="selectError">Despacho Fijo</label>
								<div class="controls">
									<label class="checkbox">
										<input type="checkbox" id="dfijo" value="1">
										Activar si fue por SIO
									</label>
								</div>
							  </div>-->
							  <div class="control-group">
								<label class="control-label" for="selectError">Nud</label>
								<div class="controls">
									<!--<select id="idN" name="idN" data-rel="chosen" data-validation-engine="validate[required]">
										<?php do{?>
											<option value="<?php echo $row3['nud']; ?>"><?php echo $row3['nud'].' - '.$row3['nombre']; ?></option>
										<?php 
										}while($row3 = $db->fetch_assoc($resultado3));	
										?>
									</select>-->
									<input class="input-xlarge focused" id="idN" name="idN" data-validation-engine="validate[required,custom[onlyNumberSp]]" type="text">
									<input class="input-xlarge focused" id="nomNud" name="nomNud" data-validation-engine="validate[required,custom[onlyNumberSp]]" type="text" readonly>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="selectError">Producto</label>
								<div class="controls">
									<select id="idP" name="idP" data-rel="chosen" data-validation-engine="validate[required]">
										<?php do{?>
											<option value="<?php echo $row2['idProductoCambio']; ?>"><?php echo $row2['DescripcionInterna']; ?></option>
										<?php 
										}while($row2 = $db->fetch_assoc($resultado2));	
										?>
									</select>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="selectError3">Motivo</label>
								<div class="controls">
									<select id="idM" name="idM" data-validation-engine="validate[required]">
										<?php do{?>
											<option value="<?php echo $row['idCambiosMotivos']; ?>"><?php echo $row['Descripcion']; ?></option>
										<?php 
										}while($row = $db->fetch_assoc($resultado));	
										?>
									</select>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="focusedInput">Cantidad</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="cant" name="cant" data-validation-engine="validate[required,custom[onlyNumberSp]]" type="text">
								</div>
							  </div>
						  
							  <div class="form-actions">
								<button type="button" id="btn_aMotivos" name="btn_aMotivos" class="btn btn-primary">Agregar</button>
								<button class="btn">Cancelar</button>
							  </div>
							</fieldset>
						  </form>
					</div>
					<div class="box-content" id="div_motivos" name="div_motivos"></div>
				</div><!--/span-->
					
			</div><!--/row-->
			
<?php include('footer.php'); ?>
