<?php
require_once("class.MySQL.php");

class PromedioGrafica extends MySQL
{	 

	/*** Atributos ***/

	private $nSemana = NULL;
	private $idDeposito = NULL;
	private $tOperacion = NULL;
	public $vMin = NULL;
	public $vMax = NULL;
	private $horaInicio = NULL;
	private $horaFin = NULL;

	private $valorNull = NULL;


	/*** Fin area de atributos ***/

	/*** Setters ***/

	public function setNSemana ($nsemana){

		$this->nSemana = $nsemana;
	}

	public function setIdDesposito ($iddeposito) {

		$this->idDeposito = $iddeposito;
	}

	public function setToperacion($tOperacion){

		$this->tOperacion = $tOperacion;

	}

	/*** Fin area de Setters ***/


	/*** Inicio de Detallado Gráfico***/

	public function obtenerEfectividadVisita (){

		$consulta = "SELECT ROUND(SUM(efectividadVisita)/COUNT(efectividadVisita) * 100,2) AS pEfectividad FROM Indicador i, Ruta r WHERE i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." AND  i.nSemana = ".$this->nSemana." AND i.idDeposito = ".$this->idDeposito." GROUP BY diaN ORDER BY diaN";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$cadena = NULL;
		do {

			$cadena .= $row['pEfectividad'].',';

		}while($row = $this->fetch_assoc($resultado));

		$cadena = substr($cadena, 0, -1);

		return $cadena;

	}

	public function obtenerMinimoVisita(){

		$consulta = "SELECT ROUND(SUM(efectividadVisita)/COUNT(efectividadVisita) * 100,2) AS pEfectividad FROM Indicador i, Ruta r WHERE i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." AND  i.nSemana = ".$this->nSemana." AND i.idDeposito = ".$this->idDeposito." GROUP BY diaN ORDER BY pEfectividad LIMIT 1";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		return $row['pEfectividad'];

	}

	public function obtenerMaximoVisita(){

		$consulta = "SELECT ROUND(SUM(efectividadVisita)/COUNT(efectividadVisita) * 100,2) AS pEfectividad FROM Indicador i, Ruta r WHERE i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." AND  i.nSemana = ".$this->nSemana." AND i.idDeposito = ".$this->idDeposito." GROUP BY diaN ORDER BY pEfectividad DESC LIMIT 1";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		return $row['pEfectividad'];

	}


	public function obtenerEfectividadEntregaCajas (){

		$consulta = "SELECT ROUND(SUM(efectividadEntregaCajas)/COUNT(efectividadEntregaCajas) * 100,2) AS pEfectividadCajas FROM Indicador i, Ruta r WHERE i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." AND i.nSemana = ".$this->nSemana." AND i.idDeposito = ".$this->idDeposito." GROUP BY diaN ORDER BY diaN";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$cadena = NULL;
		do {

			$cadena .= $row['pEfectividadCajas'].',';

		}while($row = $this->fetch_assoc($resultado));

		$cadena = substr($cadena, 0, -1);

		return $cadena;

	}

	public function obtenerMinimoCajas(){

		$consulta = "SELECT ROUND(SUM(efectividadEntregaCajas)/COUNT(efectividadEntregaCajas) * 100,2) AS pEfectividadCajas FROM Indicador i, Ruta r WHERE i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." AND i.nSemana = ".$this->nSemana." AND i.idDeposito = ".$this->idDeposito." GROUP BY diaN ORDER BY pEfectividadCajas LIMIT 1";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		return $row['pEfectividadCajas'];

	}

	public function obtenerMaximoCajas(){

		$consulta = "SELECT ROUND(SUM(efectividadEntregaCajas)/COUNT(efectividadEntregaCajas) * 100,2) AS pEfectividadCajas FROM Indicador i, Ruta r WHERE i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." AND i.nSemana = ".$this->nSemana." AND i.idDeposito = ".$this->idDeposito." GROUP BY diaN ORDER BY pEfectividadCajas DESC LIMIT 1";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		return $row['pEfectividadCajas'];

	}

	public function obtenerEfectividadEntregaClientes (){

		$consulta = "SELECT ROUND(SUM(efectividadEntregaClientes)/COUNT(efectividadEntregaClientes) * 100,2) AS pEfectividadClientes FROM Indicador i, Ruta r WHERE i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." AND i.nSemana = ".$this->nSemana." AND i.idDeposito = ".$this->idDeposito." GROUP BY diaN ORDER BY diaN";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$cadena = NULL;
		do {

			$cadena .= $row['pEfectividadClientes'].',';

		}while($row = $this->fetch_assoc($resultado));

		$cadena = substr($cadena, 0, -1);

		return $cadena;


	}

	public function obtenerMinimoClientes (){

		$consulta = "SELECT ROUND(SUM(efectividadEntregaClientes)/COUNT(efectividadEntregaClientes) * 100,2) AS pEfectividadClientes FROM Indicador i, Ruta r WHERE i.idRuta = r.idRuta AND r.tipo = 0 AND i.nSemana = ".$this->nSemana." AND i.idDeposito = ".$this->idDeposito." GROUP BY diaN ORDER BY pEfectividadClientes LIMIT 1";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		return $row['pEfectividadClientes'];

	}

	public function obtenerMaximoClientes (){

		$consulta = "SELECT ROUND(SUM(efectividadEntregaClientes)/COUNT(efectividadEntregaClientes) * 100,2) AS pEfectividadClientes FROM Indicador i, Ruta r WHERE i.idRuta = r.idRuta AND r.tipo = 0 AND i.nSemana = ".$this->nSemana." AND i.idDeposito = ".$this->idDeposito." GROUP BY diaN ORDER BY pEfectividadClientes DESC LIMIT 1";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		return $row['pEfectividadClientes'];

	}

	public function obtenerRangoFecha(){
		

		$consulta = "SELECT CONCAT(dias,' ',diaN,' de ',mes) AS fecha  FROM Indicador WHERE nSemana = ".$this->nSemana." AND idDeposito = ".$this->idDeposito." GROUP BY fecha ORDER BY diaN";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);
		$fecha = "|";

		do{

			$fecha .= $row['fecha']."|";

		}while($row = $this->fetch_assoc($resultado));

		return $fecha;
	}

	/*** Inicio de Envío y Recepción de Datos***/

	public function obtenerRangoDiaTo(){

		$consulta = "SELECT dia FROM Tiempos WHERE nSemana = ".$this->nSemana."  AND tipo = ".$this->tOperacion;
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);
		do{
			
			$dia .= $row['dia'];

		}while($row = $this->fetch_assoc($resultado));

		return $dia;

	}

	public function obtenerRangoYPromedioE($vMin,$vMax){

		$rango = $vMax - $vMin;

		$rango = $rango/10;

		//echo 'el rango es: '.$rango;
		//echo '<br>';

		$valorMinimo = $vMin - $rango;

		$this->vMin = $valorMinimo;

		//echo '<br>';

		$vMin = number_format($valorMinimo,2);



		for($x=0;$x<=11;$x++){

			$valor .= "|".$vMin."%";

			$this->vMax = $vMin;

			$vMin = number_format($vMin + $rango,2);


		}

		$valor .= "|";

		return $valor;

	}

	public function obtenerRangoYTiemposO(){

		

	}

	public function obtenerInicioMinimo (){

		$consulta = "SELECT SUBTIME(inicio,'02:00:00') AS hinicio FROM Tiempos WHERE idDeposito =".$this->idDeposito." AND nSemana=".$this->nSemana." AND tipo = ".$this->tOperacion." ORDER inicio LIMIT 1";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$this->horaInicio = $row['hinicio'];
	}

	public function obtenerFinMaximo(){
		$consulta = "SELECT ADDTIME(fin,'02:00:00') AS hfin FROM Tiempos WHERE idDeposito =".$this->idDeposito." AND nSemana=".$this->nSemana." AND tipo = ".$this->tOperacion." ORDER inicio DESC LIMIT 1";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$this->horaFin = $this->row['hfin'];

	}

	public function obtenerInicioOptimo(){


		$consulta = "SELECT inicioOptimo FROM Tiempos WHERE idDeposito = ".$this->idDeposito." AND nSemana = ".$this->nSemana." AND tipo = ".$this->tOperacion;
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		do{

			$cadena .= $row['inicioOptimo']."|";

		}while($row = $this->fetch_assoc($resultado));

		$cadena = substr($cadena,0,-1);

		return $cadena;
	
	}

	public function obtenerColadeEspera(){

		$consulta = "SELECT colaEspera FROM Tiempos WHERE idDeposito = ".$this->idDeposito." AND nSemana = ".$this->nSemana." AND tipo = ".$this->tOperacion;
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		do {

			$cadena .= $row['colaEspera']."|";

		} while ($row = $this->fetch_assoc($resultado));

		$cadena = $substr($cadena,0,-1);

		return $cadena;

	}

	public function obtenetTiempoDisenio(){
		$consulta = "SELECT disenio FROM Tiempos WHERE idDeposito = ".$this->idDeposito." AND nSemana = ".$this->nSemana." AND tipo =".$this->tOperacion;
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);
		do {

			$cadena .= $row['disenio']."|";
			
		} while ($row = $this->fetch_assoc($resultado));

		$cadena = substr($cadena, 0,-1);

		return $cadena;
	}

	public function obtenerTiempoExcedido(){
		$consulta = "SELECT tiempoExcedido FROM Tiempos WHERE idDeposito = ".$this->idDeposito." AND nSemana = ".$this->nSemana." AND tipo =".$this->tOperacion;
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		do {

			$cadena .= $row['tiempoExcedido'];

		} while ($row = $this->fetch_assoc($resultado));

		$cadena = substr($cadena, 0,-1);

		return $cadena;

	}

	/*** Inicio de Detallado Númerico ***/

	public function obtenerTablaRutasProgramadas(){

		$consulta = "SELECT COUNT(i.idRuta) AS nRuta, dias, diaN, mes FROM Indicador i, Ruta r WHERE i.idDeposito = ".$this->idDeposito." AND i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." AND i.nSemana = ".$this->nSemana." GROUP BY dias ORDER BY diaN";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$tabla = "<thead>
						<tr>
							<th>Día de la Semana</th>
							<th>Día</th>
							<th>Mes</th>
							<th>Número de Rutas</th>
						</tr>
					</thead>
				<tbody>";

		do{

			$tabla .= "<tr>
							<td class='center'>".$row['dias']."</td>
							<td class='center'>".$row['diaN']."</td>
							<td class='center'>".$row['mes']."</td>
							<td class='center'>".$row['nRuta']."</td>
						<tr>";

		}while($row = $this->fetch_assoc($resultado));

		$tabla .= "</tbody>";
		
		//$tabla .= "Ciao Mondo!";

		return $tabla;

	}

	public function obtenerTablaVisitasProgramadas(){

		$consulta = "SELECT i.idRuta, SUM(i.visitasProgramadas) AS totalVisitas, dias, diaN, Mes FROM Indicador i, Ruta r WHERE i.idRuta = r.idRuta AND i.idDeposito = ".$this->idDeposito." AND i.nSemana = ".$this->nSemana." AND r.tipo = ".$this->tOperacion." GROUP BY i.idRuta, dias ORDER BY diaN, idRuta";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$tabla = "<thead>
						<tr>
							<th>Ruta</th>
							<th>Total Visitas</th>
							<th>Día de la Semana</th>
							<th>Día</th>
							<th>Mes</th>
						</tr>
					</thead>
				<tbody>";
		do{

			$tabla .= "<tr>
							<td class='center'>".$row['idRuta']."</td>
							<td class='center'>".$row['totalVisitas']."</td>
							<td class='center'>".$row['dias']."</td>
							<td class='center'>".$row['diaN']."</td>
							<td class='center'>".$row['Mes']."</td>
						<tr>";

		}while($row = $this->fetch_assoc($resultado));

		$tabla .= "</tbody>";

		return $tabla;


	}

	public function obtenerTablaEfectividadVisita(){

		$consulta = "SELECT i.idRuta, i.mes, i.dias, i.diaN, ROUND(i.efectividadVisita * 100,2) AS efectividadV FROM Indicador i, Ruta r WHERE i.idDeposito = ".$this->idDeposito." AND i.nSemana = ".$this->nSemana." AND i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." ORDER BY i.diaN";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$tabla = "<thead>
						<tr>
							<th>Día de la Semana</th>
							<th>Día</th>
							<th>Mes</th>
							<th>Ruta</th>
							<th>Efectividad Visita</th>
						</tr>
					</thead>
				<tbody>";

		do{

			$tabla .= "<tr>
							<td class='center'>".$row['dias']."</td>
							<td class='center'>".$row['diaN']."</td>
							<td class='center'>".$row['mes']."</td>
							<td class='center'>".$row['idRuta']."</td>
							<td class='center'>".$row['efectividadV']."%</td>
						<tr>";

		}while($row = $this->fetch_assoc($resultado));

		$tabla .= "</tbody>";
		
		//$tabla .= "Ciao Mondo!";

		return $tabla;

	}

	public function obtenerTablaEfectividadCliente(){

		$consulta = "SELECT i.idRuta, i.mes, i.dias, i.diaN, ROUND(i.efectividadEntregaClientes * 100,2) AS efectividadE FROM Indicador i, Ruta r WHERE i.idDeposito = ".$this->idDeposito." AND i.nSemana = ".$this->nSemana." AND i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." ORDER BY i.diaN";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$tabla = "<thead>
						<tr>
							<th>Día de la Semana</th>
							<th>Día</th>
							<th>Mes</th>
							<th>Ruta</th>
							<th>Efectividad Entrega Cliente</th>
						</tr>
					</thead>
				<tbody>";

		do{

			$tabla .= "<tr>
							<td class='center'>".$row['dias']."</td>
							<td class='center'>".$row['diaN']."</td>
							<td class='center'>".$row['mes']."</td>
							<td class='center'>".$row['idRuta']."</td>
							<td class='center'>".$row['efectividadE']."%</td>
						<tr>";

		}while($row = $this->fetch_assoc($resultado));

		$tabla .= "</tbody>";
		
		//$tabla .= "Ciao Mondo!";

		return $tabla;

	}

	public function obtenerTablaEfectividadCajas(){

		$consulta = "SELECT i.idRuta, i.mes, i.dias, i.diaN, ROUND(i.efectividadEntregaCajas * 100,2) AS efectividadC FROM Indicador i, Ruta r WHERE i.idDeposito = ".$this->idDeposito." AND i.nSemana = ".$this->nSemana." AND i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." ORDER BY i.diaN";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$tabla = "<thead>
						<tr>
							<th>Día de la Semana</th>
							<th>Día</th>
							<th>Mes</th>
							<th>Ruta</th>
							<th>Efectividad Entrega Cajas</th>
						</tr>
					</thead>
				<tbody>";

		do{

			$tabla .= "<tr>
							<td class='center'>".$row['dias']."</td>
							<td class='center'>".$row['diaN']."</td>
							<td class='center'>".$row['mes']."</td>
							<td class='center'>".$row['idRuta']."</td>
							<td class='center'>".$row['efectividadC']."%</td>
						<tr>";

		}while($row = $this->fetch_assoc($resultado));

		$tabla .= "</tbody>";
		
		//$tabla .= "Ciao Mondo!";

		return $tabla;

	}

	public function obtenerCapacidadCamion(){

		$consulta = "SELECT i.idRuta, i.mes, i.dias, i.diaN, ROUND(i.capacidadCamion * 100,2) AS capacidadC FROM Indicador i, Ruta r WHERE i.idDeposito = ".$this->idDeposito." AND i.nSemana = ".$this->nSemana." AND i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." ORDER BY i.diaN";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$tabla = "<thead>
						<tr>
							<th>Día de la Semana</th>
							<th>Día</th>
							<th>Mes</th>
							<th>Ruta</th>
							<th>Capacidad del Camión</th>
						</tr>
					</thead>
				<tbody>";

		do{

			$tabla .= "<tr>
							<td class='center'>".$row['dias']."</td>
							<td class='center'>".$row['diaN']."</td>
							<td class='center'>".$row['mes']."</td>
							<td class='center'>".$row['idRuta']."</td>
							<td class='center'>".$row['capacidadC']."%</td>
						<tr>";

		}while($row = $this->fetch_assoc($resultado));

		$tabla .= "</tbody>";
		
		//$tabla .= "Ciao Mondo!";

		return $tabla;

	}

	public function obtener2Cajas(){

		//$consulta = "SELECT i.idRuta, i.Mes, i.dias, i.diaN, ROUND(i.dosCajas * 100,2) AS dosC FROM Indicador i, Ruta r WHERE i.idDeposito = ".$this->idDeposito." AND i.nSemana = ".$this->nSemana." AND i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." ORDER BY i.diaN";
		$consulta = "SELECT i.idRuta, i.Mes, i.dias, i.diaN, ROUND(i.dosCajas,2) AS dosC FROM Indicador i, Ruta r WHERE i.idDeposito = ".$this->idDeposito." AND i.nSemana = ".$this->nSemana." AND i.idRuta = r.idRuta AND r.tipo = ".$this->tOperacion." ORDER BY i.diaN";
		$resultado = $this->consulta($consulta);
		$row = $this->fetch_assoc($resultado);

		$tabla = "<thead>
						<tr>
							<th>Día de la Semana</th>
							<th>Día</th>
							<th>Mes</th>
							<th>Ruta</th>
							<th>Cajas menor a 2</th>
						</tr>
					</thead>
				<tbody>";

		do{

			$tabla .= "<tr>
							<td class='center'>".$row['dias']."</td>
							<td class='center'>".$row['diaN']."</td>
							<td class='center'>".$row['Mes']."</td>
							<td class='center'>".$row['idRuta']."</td>
							<td class='center'>".$row['dosC']."</td>
						<tr>";

		}while($row = $this->fetch_assoc($resultado));

		$tabla .= "</tbody>";
		
		//$tabla .= "Ciao Mondo!";

		return $tabla;

	}

}?>	