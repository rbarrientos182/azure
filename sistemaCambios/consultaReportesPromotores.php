<?php include('header.php'); 

$idoperacion = $_SESSION['idoperacion'];
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="consultaReportesPromotores.php">Reporte</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Reporte</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>

					<div class="box-content">
						<form class="form-horizontal" id="registro" action="reportes/reportePromotorPDF.php" method="post" target="_blank">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="selectError">Fecha Preventa</label>
								<div class="controls">
									<input type="text" class="input-xlarge uneditable-input datepicker" id="fechaPre" name="fechaPre" value="<?php echo date('Y-m-d')?>">
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
