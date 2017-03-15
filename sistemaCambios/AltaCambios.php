<?php include('header.php'); 
$idoperacion = $_SESSION['idoperacion'];

/** Query del catalogo de motivos **/
$consulta = "SELECT idCambiosMotivos,Descripcion,agrupador  FROM CambiosMotivos WHERE agrupador='Defecto Produccion' ORDER BY Descripcion";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

/** Query para sacar los agrupamientos **/
$consultaA = "SELECT agrupador FROM CambiosMotivos WHERE agrupador IS NOT NULL GROUP BY agrupador  ORDER BY agrupador";
$resultadoA = $db->consulta($consultaA);
$rowA = $db->fetch_assoc($resultadoA);

/** Query del catalogo de los productos por CEDIS **/
$consulta2 = "SELECT 
    idProductoCambio, DescripcionInterna, Descripcion, p.sku
FROM
    usrcambios us
        INNER JOIN
    rutascambios rc ON rc.idoperacion = us.idoperacion
        AND ppp = ruta
        INNER JOIN
    productoscambios pc ON pc.idoperacion = us.idoperacion
        AND pc.tmercado = rc.tmercado
        INNER JOIN
    Productos P ON Pc.sku = P.sku
WHERE
    us.idoperacion = $idoperacion AND pc.estatus = 1 AND pc.estatus = 1
        AND numempleado = $NumEmpleado
ORDER BY p.sku";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);


/***Query para comprobar si ya se cerro el despacho dinamico***/
$idop = $_SESSION['idoperacion'];
$numempleado = $_SESSION['NumEmpleado'];
$ppp = $_SESSION['ppp'];
$fechaO = date('Y-m-d');

$consultaC = "SELECT COUNT(*) AS cuantos FROM rutascambios WHERE idoperacion = $idop AND ruta = $ppp AND tipo = 2";
$resultadoC = $db->consulta($consultaC);
$rowC = $db->fetch_assoc($resultadoC);

if($rowC['cuantos']==1){
	
	$consultaCC = "SELECT COUNT(*) AS cuantos FROM capturacambios WHERE idoperacion = $idop AND estatusDis = 1 AND FechaCambio = '$fechaO'";
	$resultadoCC = $db->consulta($consultaCC);
	$rowCC = $db->fetch_assoc($resultadoCC);
	if($rowCC['cuantos']==1){
		$res = 1;
	}	
	else{
		$res = 0;
	}
}
else{
	$res = 0;
}
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="AltaCambios.php">Captura Cambios</a>
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
						<form id="formCambioMotivo" name="formCambioMotivo" class="form-horizontal">
							<fieldset>

							  <div class="control-group">
								<label class="control-label" for="selectError">Fecha Preventa</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="fechaO" value="<?php echo date('Y-m-d')?>" readonly>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="selectError">Nud</label>
								<div class="controls">
									<input class="input-xlarge focused" id="idNud" name="idNud" data-validation-engine="validate[required,custom[onlyNumberSp]]" onchange="mostrarNombreCliente()" type="text">
									<input class="input-xlarge focused" id="nomNud" name="nomNud"  type="text" readonly>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="selectError3">Agrupador de Merma</label>
								<div class="controls">
									<select id="idAM" name="idAM" data-validation-engine="validate[required]">
										<?php do{?>
											<option value="<?php echo $rowA['agrupador']; ?>"><?php echo $rowA['agrupador']; ?></option>
										<?php 
										}while($rowA = $db->fetch_assoc($resultadoA));	
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
								<label class="control-label" for="selectError">Producto</label>
								<div class="controls">
									<select id="idP" name="idP" data-rel="chosen" data-validation-engine="validate[required]">
										<?php do{?>
											<option value="<?php echo $row2['idProductoCambio']; ?>"><?php echo $row2['sku'].' - '.$row2['DescripcionInterna']; ?></option>
										<?php 
										}while($row2 = $db->fetch_assoc($resultado2));	
										?>
									</select>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="focusedInput">Cantidad Pzas</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="cant" name="cant" data-validation-engine="validate[required,custom[onlyNumberSp]]" type="text">
								</div>
							  </div>
						  
							  <div class="form-actions">
								<button type="button" id="btn_aMotivos" name="btn_aMotivos" class="btn btn-primary" <?php if(date("H:i:s")>= 20.20 || $res == 1){?> disabled<?php }?>>Agregar</button>
								<button class="btn">Cancelar</button>
							  </div>
							</fieldset>
						  </form>
					</div>
					<div class="box-content" id="div_motivos" name="div_motivos"></div>
				</div><!--/span-->
					
			</div><!--/row-->
			
<?php include('footer.php'); ?>
