<?php
$no_visible_elements=true;
include('header2.php'); ?>

			<div class="row-fluid" style="text-align:center">
				<!--<div class="span12 center login-header">
					<h2>Welcome to Charisma</h2>
				</div><!--/span-->
			<!--</div><!--/row-->
				<img src="img/Pepsi-logo.png" alt="Gepp Pepsi" title="Gepp Pepsi">
			<div class="row-fluid">
				<div class="well span5 center login-box">
					<div id="d_aviso" class="alert alert-info">
						Es la primera vez que inicia sesión favor de cambiar su contraseña
					</div>
					<form class="form-horizontal" id="registro" action="cambiarPasword.php" method="post">
						<fieldset>
							<div class="input-prepend" title="Ingrese Nueva Contraseña" data-rel="tooltip">
								<span class="add-on"><i class="icon-lock"></i></span><input autofocus class="input-large span10" name="password1" id="password1" type="password" data-validation-engine="validate[required,minSize[8]]" placeholder="admin123456" />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Confirmar Nueva Contraseña" data-rel="tooltip">
								<span class="add-on"><i class="icon-lock"></i></span><input class="input-large span10" name="password2" id="password2" type="password" data-validation-engine="validate[required,minSize[8]]" placeholder="admin123456" />
							</div>
							<div class="clearfix"></div>
							<div class="clearfix"></div>

							<p class="center span5">
							<input type="submit" id="btn_cambiarPsw" name="btn_cambiarPsw" class="btn btn-primary" value="Cambiar" >
						   <!-- <button input type="button" id="btn_cambiarPsw" name="btn_cambiarPsw" class="btn btn-primary" >Ingresar</button> -->
							</p>
						</fieldset>
					</form>
				</div><!--/span-->
			</div><!--/row-->
<?php include('footer.php'); ?>
