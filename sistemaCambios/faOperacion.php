<?php include('header.php'); 

$consulta = "SELECT d.idDeposito, d.deposito FROM Deposito d  GROUP BY d.idDeposito ORDER BY deposito";
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
						<a href="faOperacion.php">Agregar Operación</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Agregar Operación</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" action="gOperacion.php" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Deposito</label>
								<div class="controls">
									<select class="input-xlarge focused" id="idDeposito" name="idDeposito">
										<?php do{?>
							  				<option value="<?php echo $row['idDeposito']?>"><?php echo $row['deposito'];?></option>
							  			<?php 
							  			}while($row = $db->fetch_assoc($resultado));
							  			?>
							  		</select>
								</div>
							  </div>
							  <div class="control-group">
							  	<label class="control-label" for="focusedInput">Tipo de Mercado</label>
							  	<div class="controls">
							  		<select class="input-xlarge focused" id="mercado" name="mercado">
							  			<option value="0">Tradicional</option>
							  			<option value="1">Moderno</option>
							  		</select>
							  	</div>
							  </div>
							   <div class="control-group">
							  	<label class="control-label" for="focusedInput">Coordinador de Despacho</label>
							  	<div class="controls">
							  		<input class="input-xlarge focused" data-validation-engine="validate[required]" id="despacho" name="despacho" type="text">
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
