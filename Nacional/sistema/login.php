<?php
$no_visible_elements=true;
include('header2.php'); ?>

			<div class="row-fluid" style="text-align:center">
				<!--<div class="span12 center login-header">
					<h2>Welcome to Charisma</h2>
				</div><!--/span-->
			<!--</div><!--/row-->
				<img src="img/logo_gepp.jpg" alt="Gepp Pepsi" title="Gepp Pepsi">
			<div class="row-fluid">
				<div class="well span5 center login-box">
					<div id="d_aviso" class="alert alert-info">
						Por favor ingrese con su Usuario y Contraseña.
					</div>
					<form class="form-horizontal" action="loguearse.php" method="post">
						<fieldset>
							<div class="input-prepend" title="Usuario" data-rel="tooltip">
								<span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span10" name="username" id="username" type="text" placeholder="admin" />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Contraseña" data-rel="tooltip">
								<span class="add-on"><i class="icon-lock"></i></span><input class="input-large span10" name="password" id="password" type="password" placeholder="admin123456" />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend">
							<label class="remember" for="remember"><input type="checkbox" id="remember" />Recordar</label>
							</div>
							<div class="clearfix"></div>

							<p class="center span5">
							<button type="submit" id="btn_ingresar" name="btn_ingresar" class="btn btn-primary">Ingresar</button>
							</p>
						</fieldset>
					</form>
				</div><!--/span-->
			</div><!--/row-->
<?php include('footer.php'); ?>
