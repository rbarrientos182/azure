<?php
$no_visible_elements=true;
include('header3.php');

$idusuario = $_SESSION['idUsuarios'];


//*** Obtenemos las regiones que tiene ***//

$consulta = "SELECT r.idRegion, r.region FROM Operaciones_has_Deposito od, Deposito d, Region r WHERE od.idUsuarios = $idusuario AND od.idDeposito = d.idDeposito AND d.idRegion = r.idRegion AND r.estatus = 1 GROUP BY region ORDER BY region";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>

			<div class="row-fluid" style="text-align:center">
				<!--<div class="span12 center login-header">
					<h2>Welcome to Charisma</h2>
				</div><!--/span-->
			<!--</div><!--/row-->
				<img src="img/logo_gepp.jpg" alt="Gepp Pepsi" title="Gepp Pepsi">
			<div class="row-fluid">
				<div class="well span5 center login-box">
					<div class="alert alert-info">
						Por favor ingrese región y deposito.
					</div>
					<form class="form-horizontal" method="post">
						<fieldset>
							<div class="input-prepend" title="Región" data-rel="tooltip">
								<label class="control-label" for="selectError3">Región:</label>
								<div class="controls">
								  <select id="listaregion" name="listaregion">
								  	<option value="">Selecciona la región</option>
								  	<?php do{

								  	?>
										<option value="<?php echo $row['idRegion']; ?>"><?php echo $row['region'] ?></option>
								  	<?php
								  		}while($row = $db->fetch_assoc($resultado));

								  	 ?>
								  </select>
								</div>
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Deposito" data-rel="tooltip">
								<label class="control-label" for="selectError3">Deposito:</label>
								<div class="controls">
								  <select id="listadeposito" name="listadeposito">
								  	<option value="">Selecciona el deposito</option>
								  </select>
								</div>
							</div>
							<div class="clearfix"></div>

							<div class="clearfix"></div>

							<p class="center span5">
							<button type="button" id="btn_ingresar2" name="btn_ingresar2" class="btn btn-primary">Ingresar</button>
							</p>
						</fieldset>
					</form>
				</div><!--/span-->
			</div><!--/row-->
<?php include('footer.php'); ?>
