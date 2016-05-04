<?php include('header.php'); 


/*** obtenemos las sesiones del idusuario y su nivel ***/
$idUsuario = $_SESSION['idUsuarios'];
$idNivel = $_SESSION['idNivel'];

// si es 0 es igual a administrador del sistema y tiene derecho a ver todos los depositos junto con todas sus operaciones
if($idNivel == 1)
{
	$consulta = "SELECT ohd.idOperaciones, ohd.idDeposito, ohd.idControl, CONCAT( d.deposito,'-',IF(ohd.idOperaciones, 'Pepsi Express','Despacho Dinamico')) AS operacion_deposito
				FROM operaciones_has_deposito ohd, deposito d
				WHERE d.idDeposito = d.idDeposito AND d.estatus =1
				GROUP BY ohd.idOperaciones";		 			
}

// si es 1 es igual a un perfil de dispatcher y sólo puede ver sus depositos asignados junto con sus operaciones.
elseif($idNivel == 2) 
{
	$consulta = "SELECT ohd.idOperaciones, ohd.idDeposito, ohd.idControl, CONCAT(d.deposito,'-',IF(ohd.idOperaciones, 'Pepsi Express','Despacho Dinamico')) AS operacion_deposito
				FROM operaciones_has_deposito ohd, deposito d
				 WHERE ohd.idDeposito = d.idDeposito AND d.estatus = 1 AND ohd.idUsuarios = $idUsuarios";			
}

$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="aTiempos.php">Agregar Tiempos</a>
					</li>
				</ul>
			</div>
			<div class="row-fluid sortable">
				<div class="box-content">
		            <form class="form-horizontal" enctype="multipart/form-data">
		            	<fieldset>
		            		<div class="control-group">
								<label class="control-label" for="date01">Selecciona el Año</label>
								<div class="controls">
									<select class="input-xlarge focused" id="anio" name="anio" onchange="mostrarConcentradoT()">
										<?php 
											$anio = date("Y");

											for($x = 2012; $x <= 2020; $x++){
										?>
												<option value="<?php echo $x; ?>" <?php if($anio==$x){ echo 'selected'; }?>><?php echo $x;?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="date01">Selecciona la Semana</label>
								<div class="controls">
									<select class="input-xlarge focused" id="nSemana" name="nSemana" onchange="mostrarConcentradoT()">
										<?php 
											$sem = date("W");

											for($y = 1; $y <= 53; $y++){
										?>
												<option value="<?php echo $y; ?>"  <?php if($sem==$y){ echo 'selected'; }?>>Semana <?php echo $y;?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="date01">Selecciona Operación-Deposito</label>
								<div class="controls">
										<select id="oDeposito" name="oDeposito" onchange="mostrarConcentradoT()">
											<option value="<?php echo $row['idControl']?>"><?php echo $row['operacion_deposito'];?></option>
										</select>
								</div>
							</div>
						
							<div class="form-actions">
								<button type="button" id="btn_aTiempos" name="btn_aTiempos" class="btn btn-primary">Mostrar Concentrado Tiempo</button>
							</div>

						</fieldset>
					</form>	
					<div class="box">
						<div class="box-header well">
							<h2><i class="icon-list-alt"></i>Concentrado Tiempo</h2>
							<div class="box-icon">
								<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							</div>
						</div>
						<div id="contenedorTiempos" class="box-content">

						</div>
					</div>
				</div><!--/row-->		
			</div><!--/row-->	
<?php include('footer.php'); ?>
