<?php 
require_once('clases/class.MySQL.php');
require_once('clases/class.Funciones.php');

$db = new MySQL();
$fn = new Funciones();


$nSemana = $_POST['nSemana'];
$oDeposito = $_POST['oDeposito'];
$anio = $_POST['anio'];

//obtenemos el deposito con los estatus de tipo operacion (0-Tradicional,1-TDC,2-Moderno)
$consulta = "SELECT d.deposito, ohd.idOperaciones AS idOp, ohd.idDeposito FROM Deposito d, operaciones_has_deposito ohd  WHERE d.idDeposito = ohd.idDeposito AND ohd.idcontrol = $oDeposito";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);


//obtenemos concentrado tiempo de la semana (-1 ya que en bd la primer semana es 0) que elegimos en el combo 
$consulta2 = "SELECT  fecha, tiempoExcedido, disenio, colaEspera, inicio, fin, Observaciones, ADDTIME( ADDTIME( inicio, disenio ), colaEspera ) AS tTotal  FROM tiempos WHERE WEEK(fecha) = $nSemana-1 AND YEAR(fecha) = $anio AND tipo = ".$row['idOp']." ORDER BY fecha  LIMIT 7";
$resultado2 = $db->consulta($consulta2);
$row2 = $db->fetch_assoc($resultado2);
$numRows = $db->num_rows($resultado2);


//obtenemos el total de dias que debe de tener el No. de semana (estos varian unicamente con la sem 53 y sem 1)
$totalDiasSemana = $fn->getNoDiasEnSemana($nSemana,$anio);

//obtenemos la direncia de cuantos dias aun no estan en la base de datos
$diferencia = $totalDiasSemana - $numRows;
?>
<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-content">
			<form class="form-horizontal" id="registro" method="post">
				<table class="table table-striped table-bordered bootstrap-datatable datable">
					<thead>
						<tr>
							<th colspan="2">Deposito:</th>
							<th colspan="6"><?php echo $row['deposito'];?></th>
						</tr>
						<tr>
							<!--<th>Deposito</th>-->
							<th><input type="hidden" id="totalReg" name="totalReg" value="<?php echo $totalDiasSemana; ?>">Fecha Preventa</th>
							<th><input type="hidden" id="idDeposito" name="idDeposito" value="<?php echo $row['idDeposito'];?>">Tiempo Excedido</th>
							<th><input type="hidden" id="idOp" name="idOp" value="<?php echo $row['idOp']; ?>">Cola de Espera</th>
							<th>Diseño</th>
							<th>Total</th>
							<th>Envío de Información</th>
							<th>R. de Información</th>
							<th>Observaciones</th>
							<!--<th>Acciones</th>-->
						</tr>
					</thead>   
					<tbody>
						<?php 
						$y=0;

						if($numRows>0)
						{ 
							//echo 'entro a if';	
							do{
								$fecha = $row2['fecha'];
								$y++;
						?>
								<tr>
									<!--<td class="center"><?php echo $row['deposito'];?></td>-->
									<td class="center"><input type="hidden" id="fecha<?php echo $y;?>" name="fecha<?php echo $y;?>" value="<?php echo $row2['fecha'];?>"><?php echo $row2['fecha'];?></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="tiempoE<?php echo $y;?>" id="tiempoE<?php echo $y;?>" type="text" value="<?php echo $row2['tiempoExcedido'];?>" readonly></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="colaE<?php echo $y;?>" id="colaE<?php echo $y;?>" type="text" value="<?php echo $row2['colaEspera'];?>" placeholder="hrs:min" onchange="obtenerTiempos('ini<?php echo $y;?>','fin<?php echo $y;?>','colaE<?php echo $y;?>','tiempoE<?php echo $y;?>','disenio<?php echo $y;?>','total<?php echo $y;?>')"></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="disenio<?php echo $y;?>" id="disenio<?php echo $y;?>" type="text" value="<?php echo $row2['disenio'];?>" readonly></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="total<?php echo $y;?>" id="total<?php echo $y;?>" type="text" value="<?php echo $row2['tTotal'];?>" readonly></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="fin<?php echo $y;?>" id="fin<?php echo $y;?>" type="time" value="<?php echo $row2['fin'];?>" placeholder="hrs:min" onchange="obtenerTiempos('ini<?php echo $y;?>','fin<?php echo $y;?>','colaE<?php echo $y;?>','tiempoE<?php echo $y;?>','disenio<?php echo $y;?>','total<?php echo $y;?>')"></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="ini<?php echo $y;?>" id="ini<?php echo $y;?>" type="time" value="<?php echo $row2['inicio'];?>" placeholder="hrs:min"  onchange="obtenerTiempos('ini<?php echo $y;?>','fin<?php echo $y;?>','colaE<?php echo $y;?>','tiempoE<?php echo $y;?>','disenio<?php echo $y;?>','total<?php echo $y;?>')"></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="obs<?php echo $y;?>" id="obs<?php echo $y;?>" type="text" value="<?php echo $row2['Observaciones'];?>"></td>
									<!--<td class="center">
										<a class="btn btn-danger" href="#">
											<i class="icon-trash icon-white"></i> 
											Delete
										</a>
									</td>-->
								</tr>
						<?php 
							}while($row2 = $db->fetch_assoc($resultado2));
						}
						if($diferencia>0)
						{
							// si aún no hay ningún registro capturado de la semana elegida se obtiene la fecha del día lunes
							if($diferencia==$totalDiasSemana){

								$fecha = $fn->getDiasEnSemana($nSemana,$anio);
								$nuevaFecha = $fecha[0];
							}

							for($x=0;$x<$diferencia;$x++)
							{
								$y++;	
						?>
								<tr>
									<!--<td><?php echo $row['deposito'];?></td>-->
									<td class="center"><input type="hidden" id="fecha<?php echo $y?>" name="fecha<?php echo $y?>" value="<?php echo $nuevaFecha?>"><?php echo $nuevaFecha;?></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="tiempoE<?php echo $y?>" id="tiempoE<?php echo $y?>" type="text" value="00:00" readonly></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="colaE<?php echo $y?>" id="colaE<?php echo $y?>" type="text" placeholder="hrs:min" onchange="obtenerTiempos('ini<?php echo $y;?>','fin<?php echo $y;?>','colaE<?php echo $y;?>','tiempoE<?php echo $y;?>','disenio<?php echo $y;?>','total<?php echo $y;?>')"></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="disenio<?php echo $y?>" id="disenio<?php echo $y?>" type="text" value="00:00" readonly></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="total<?php echo $y?>" id="total<?php echo $y?>" type="text" value="00:00" readonly></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="fin<?php echo $y?>" id="fin<?php echo $y?>" type="text" placeholder="hrs:min" onchange="obtenerTiempos('ini<?php echo $y;?>','fin<?php echo $y;?>','colaE<?php echo $y;?>','tiempoE<?php echo $y;?>','disenio<?php echo $y;?>','total<?php echo $y;?>')"></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="ini<?php echo $y?>" id="ini<?php echo $y?>" type="text" placeholder="hrs:min" onchange="obtenerTiempos('ini<?php echo $y;?>','fin<?php echo $y;?>','colaE<?php echo $y;?>','tiempoE<?php echo $y;?>','disenio<?php echo $y;?>','total<?php echo $y;?>')"></td>
									<td class="center"><input class="input-small focused" data-validation-engine="validate[required]" name="obs<?php echo $y?>" id="obs<?php echo $y?>" type="text"></td>
									<!--<td class="center">
										<a class="btn btn-danger" href="#">
											<i class="icon-trash icon-white"></i> 
											Delete
										</a>
									</td>-->
								</tr>
						<?php
								$nuevaFecha = strtotime('+1 day', strtotime($nuevaFecha));

								$nuevaFecha = date('Y-m-d',$nuevaFecha);
							} // fin de for
						} // fin de if
						?>
						<tr>
							<td colspan="8" class="right">
								<button type="button" id="btn_gConcentradoT" name="btn_gConcentradoT" class="btn btn-primary" onclick="guardarConcentradoT()">Guardar</button>
								<button type="reset" class="btn">Cancelar</button>
							</td>
						</tr>
					</tbody>
				</table>
			</form>            
		</div>
	</div><!--/span-->
</div><!--/row-->
<?php include('footer2.php'); ?>