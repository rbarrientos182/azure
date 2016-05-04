<?php include('header.php'); 


//obtenemos las semanas que existen en nuestra base de datos
$consulta = "SELECT nSemana FROM Indicador GROUP BY nSemana ORDER BY nSemana DESC";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);


//obtenemos las variables de sesiones iddeposito e idusuarios
$idusuarios = $_SESSION['idUsuarios'];
$iddeposito = $_SESSION['idDeposito'];

//obtenermos los tipos de operaciones que tiene el dispatcher en el cedis
$consulta2 = "SELECT o.idOperaciones, o.nombre, o.tipo FROM Operaciones_has_Deposito od, Operaciones o WHERE od.idOperaciones = o.idOperaciones AND od.idUsuarios = $idusuarios AND od.idDeposito = $iddeposito AND o.estatus = 1 GROUP BY o.nombre ORDER BY o.nombre";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);
?>


			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="estadisticas.php">Detallado Gráficos</a>
					</li>
				</ul>
			</div>

			<div class="row-fluid sortable">
				<div class="box-content">
            <form class="form-horizontal" enctype="multipart/form-data">
            	<fieldset>
					<div class="control-group">
						<label class="control-label" for="date01">Selecciona la Semana</label>
						<div class="controls">
							<select id="nSemana" name="nSemana">
								<?php do {?>
									<option value="<?php echo $row['nSemana'];?>">Semana <?php echo $row['nSemana'];?></option>
								<?php }while($row = $db->fetch_assoc($resultado));?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="date01">Selecciona tipo Efectividad</label>
						<div class="controls">
								<select id="tEfectividad" name="tEfectividad">
									<option value="0">Efectividad Visita</option>
									<option value="1">Efectividad Entrega Clientes</option>
									<option value="2">Efectividad Entrega Cajas</option>
								</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="date01">Selecciona tipo Operación</label>
						<div class="controls">
								<select id="tOperacion" name="tOperacion">
									<?php do{ ?>
										<option value="<?php echo $row2['tipo'];?>"><?php echo $row2['nombre']; ?></option>
									<?php }while($row2 = $db->fetch_assoc($resultado2)); ?>
								</select>
						</div>
					</div>
					<!--<div class="control-group">
						<label class="control-label">Opciones</label>
						<div class="controls">
							<label class="checkbox inline">
								<input type="radio" name="optionsRadios" id="optionsRadios1" value="1" checked="checked"> Gráfica de Barra
							</label>
							<label class="checkbox inline">
								<input type="radio" name="optionsRadios" id="optionsRadios2" value="2"> Gráfica de Pastel
							</label>
							<label class="checkbox inline">
								<input type="radio" name="optionsRadios" id="optionsRadios3" value="3"> Gráfica de una Función
							</label>
						</div>
					</div>-->
					<div class="form-actions">
						<button type="button" id="btn_mGrafica" class="btn btn-primary">Mostrar Gráfica</button>
					</div>

				</fieldset>
			</form>	
				<div class="box">
					<div class="box-header well">
						<h2><i class="icon-list-alt"></i>Gráfica</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div id="contenedorGrafica" class="box-content">

					</div>
				</div>

			</div><!--/row-->		
				 
		</div><!--/row-->
		
<?php include('footer.php'); ?>
