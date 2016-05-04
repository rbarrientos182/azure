<?php
$no_visible_elements=true;
include('header2.php'); 

$NumEmpleado = $_SESSION['NumEmpleado'];

/** obtenemos los depositos que tiene el usuario**/
$consulta = "SELECT o.idoperacion, CONCAT(d.deposito,IF(o.mercado,' - Moderno',' - Tradicional')) AS nombreDeposito FROM UsrCambios uc INNER JOIN operaciones o ON uc.idoperacion = o.idoperacion INNER JOIN Deposito d ON o.idDeposito = d.idDeposito WHERE uc.NumEmpleado = $NumEmpleado";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div class="row-fluid" style="text-align:center">
				<img src="img/logo_gepp.jpg" alt="Gepp Pepsi" title="Gepp Pepsi">
			<div class="row-fluid">
				<div class="well span5 center login-box">
					<div id="d_aviso" class="alert alert-info">
						Seleccione el depósito a entrar
					</div>
					<form class="form-horizontal" id="registro" action="obtenerDepositoLogin.php" method="post">
						<fieldset>
							<div class="input-prepend" title="Depósito" data-rel="tooltip">
								<span class="add-on"><i class="icon-lock"></i></span>
								<select id="idop" name="idop">
								<?php do{?>
									<option value="<?php echo $row['idoperacion'];?>"><?php echo $row['nombreDeposito']; ?></option>
								<?php } while($row = $db->fetch_assoc($resultado));?>
								</select>
							</div>
							<div class="clearfix"></div>
							<div class="clearfix"></div>
							<div class="clearfix"></div>
							<p class="center span5">
							<input type="submit" id="btn_Deposito" name="btn_Deposito" class="btn btn-primary" value="Aceptar" >
							</p>
						</fieldset>
					</form>
				</div><!--/span-->
			</div><!--/row-->
<?php include('footer.php'); ?>
