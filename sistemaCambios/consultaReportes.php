<?php include('header.php'); 
$idoperacion = $_SESSION['idoperacion'];
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="consultaReportes.php">Reportes</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Reportes</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>

					<div class="box-content">
						<form class="form-horizontal" id="registro" action="reportes/consultarReportes.php" method="post" target="_blank">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="selectError">Fecha Preventa</label>
								<div class="controls">
									<input type="text" class="input-xlarge uneditable-input datepicker" id="fechaPre" name="fechaPre" value="<?php echo date('Y-m-d')?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="selectError">Tipo de Reporte</label>
								<div class="controls">
									<select id="tipoR" name="tipoR" data-validation-engine="validate[required]">
										<!--<?php if($nivel==1 || $nivel==4){?><option value="0">Reporte Supervisor (por producto)</option><?php }?>-->
										<option value="1">Reporte Vendedor (por producto)</option>
										<option value="2">Reporte Bodega (por producto)</option>
										<option value="5">Reporte Bodega (por producto Excel)</option>
										<option value="3">Reporte Administración (por Motivo)</option>
										<option value="4">Reporte Administración (Detallado)</option>
										<option value="6">Reporte Indicadores</option>
									</select>
								</div>
							  </div>
							  <div class="form-actions">
								<button type="submit" id="btn_consultaR" name="btn_consultaR" class="btn btn-primary">Consultar</button>
								<button type="reset" class="btn">Cancelar</button>
							  </div>
							</fieldset>
						  </form>
					</div>
					<div class="box-content" id="div_consultaR" name="div_consultaR"></div>
				</div><!--/span-->
					
			</div><!--/row-->
			
<?php include('footer.php'); ?>
