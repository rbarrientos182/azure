<?php include('header.php');


/** Obtenemos las regiones por la cual se empezara el filtro**/

$consulta = "SELECT idRegion, region FROM Region ORDER BY region";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="filtroClientes.php">Clientes</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Clientes</h2>
						<div class="box-icon">
							<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="registro" enctype="multipart/form-data">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="focusedInput">Región</label>
									<div class="controls">
										<select id="idR" name="idR" data-validation-engine="validate[required]">
											<option value="">Selecciona una Región</option>
											<?php do{?>
												<option value="<?php echo $row['idRegion'] ?>"><?php echo $row['region']; ?></option>
											<?php 
										   	}while($row = $db->fetch_assoc($resultado));	
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="focusedInput">Zona</label>
									<div class="controls">
										<select id="idZ" name="idZ" data-validation-engine="validate[required]">
											<option value="">Selecciona una Zona</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="focusedInput">Depósito</label>
									<div class="controls">
										<select id="idD" name="idD" data-validation-engine="validate[required]">
											<option value="">Selecciona un Depósito</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="focusedInput">Ruta de Entrega</label>
									<div class="controls">
										<select id="idRu" name="idRu" data-validation-engine="validate[required]">
											<option value="">Selecciona una Ruta</option>
										</select>
									</div>
								</div>
								<div class="form-actions">
								  	<button type="button" id="btn_Buscar" name="btn_Buscar" class="btn btn-primary">Buscar</button>
							  </div>
							</fieldset>
						</form>	
						<div id="contenedorFiltroClientes" class="box-content">
							
						</div>						
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

<?php include('footer.php'); ?>
