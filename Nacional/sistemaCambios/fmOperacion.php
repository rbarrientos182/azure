<?php include('header.php'); 
$id = $_GET['id'];
$id2 = $_GET['id2'];

$consulta = "SELECT o.idDeposito, o.coordinador_despacho, d.deposito,  IF(o.mercado,'Moderno','Tradicional') AS tmercado FROM operaciones o INNER JOIN deposito d 
ON o.idDeposito = d.idDeposito WHERE o.idOperacion = $id AND o.mercado = $id2";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="operaciones.php">Operaciones</a><span class="divider">/</span>
					</li>
					<li>
						<a href="fmOperacion.php?id=<?php echo $id; ?>&id2=<?php echo $id2; ?>">Modificar Operación</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Modificar Operación</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="mOperacion.php" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Deposito</label>
								<div class="controls">
									<input class="input-xlarge focused" name="nombre" id="nombre" type="text" value="<?php echo $row['deposito']; ?>" readonly>
								</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Tipo Mercado</label>
							  	<div class="controls">
							  		<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
							  		<input type="hidden" id="id2" name="id2" value="<?php echo $id2; ?>">
							  		<input class="input-xlarge focused" name="mercado" id="mercado" type="text" value="<?php echo $row['tmercado']; ?>" readonly> 	
							  	</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Coordinador Despacho</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" name="despacho" id="despacho" type="text" value="<?php echo $row['coordinador_despacho']; ?>">
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

