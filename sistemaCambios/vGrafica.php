<?php 
if (!isset($_SESSION)) 
{
	session_start();
}

require_once('clases/class.Graficas.php');
require_once('clases/class.PromedioGrafica.php');
//require_once('clases/class.MySQL.php');

$grafica = new Graficas();
$pGrafica = new PromedioGrafica();
//$db = new MySQL();

$nSemana = $_POST['nSemana'];
$tEfectividad = $_POST['tEfectividad'];
$tOperacion = $_POST['tOperacion'];
$iddeposito = $_SESSION['idDeposito'];


/*$consulta = "SELECT idRuta, fecha, $campo FROM Indicador WHERE nSemana = $nSemana AND idDeposito = ".$iddeposito." ORDER BY fecha";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);*/

/*** Mandamos a llamar a nuestro setters de nSemana y idDeposito ***/

$pGrafica->setNSemana($nSemana);
$pGrafica->setIdDesposito($iddeposito);
$pGrafica->setToperacion($tOperacion);
/*** ***/

//obtenemos el valor del campo de la efectividad que queremos sacar
if($tEfectividad==0){

	//echo 'entro a efectividad visita';
	echo $valores = $pGrafica->obtenerEfectividadVisita();
	//echo '<br> el minimo es: ';
	$vMin = $pGrafica->obtenerMinimoVisita();
	//echo '<br> el maximo es:';
	$vMax = $pGrafica->obtenerMaximoVisita();
}

elseif ($tEfectividad==1) {

	//echo 'Entro a efectividad entrega clientes';
	echo $valores = $pGrafica->obtenerEfectividadEntregaClientes();
	//echo '<br> el minimo es:';
	$vMin = $pGrafica->obtenerMinimoClientes();
	//echo '<br> el maximo es:';
	$vMax = $pGrafica->obtenerMaximoClientes();
}

elseif ($tEfectividad==2) {
	//echo 'entro a efectividad entrega cajas';
	echo $valores = $pGrafica->obtenerEfectividadEntregaCajas();
	//echo '<br> el minimo es: ';
	$vMin = $pGrafica->obtenerMinimoCajas();
	//echo '<br> el maximo es: ';
	$vMax = $pGrafica->obtenerMaximoCajas();
}

//echo "salio de los ifs <br>";
$grafica->titulografica = "Estadistícas";
$grafica->dimensiones = "1000x300";
$grafica->coloresdebarras = "2362A1";

//echo $pGrafica->obtenerRangoY($vMin,$vMax);

//echo "<br>";
//echo "salio de la funcion obtenerrangoy <br>";
//echo "<br>";
$grafica->y1 = $pGrafica->obtenerRangoYPromedioE($vMin,$vMax);
//echo "<br>";
$grafica->y2="|Promedio|";

$fecha = $pGrafica->obtenerRangoFecha();
//echo "<br> salio de obtenerRangoFecha";
//echo $grafica->ObtenerPromedio(100,95.40);

$grafica->valores = $valores;
$grafica->x1= $fecha;
$grafica->x2="|Fecha|";

//echo 'el valor minimo de la grafica es '.$pGrafica->vMin;
//echo 'el valor maximo de la grafica es '.$pGrafica->vMax;

$grafica->vMin = $pGrafica->vMin;
$grafica->vMax = $pGrafica->vMax;

/*echo $fecha;

echo '<br>';

echo $opcion;

echo '<br>';

echo $iddeposito;

echo '<br>';

echo $tRuta;*/
//echo 'la grafica es '.$grafica->unaFuncion();

//echo $grafica->unaFuncion();

?>
<img src="<?php echo $grafica->unaFuncion();?>" alt="Estadisticas"/>
<!--<img src="https://chart.googleapis.com/chart?chtt=Estadistícas&cht=lc&amp;chco=2362A1,00FF00,0000FF&amp;chs=1000x300&amp;chd=s:FOETHECat,lkjtf3asv,KATYPSNXJ&amp;chxt=x,y&amp;chxl=0:|Oct|Nov|Dec|1:||20K||60K||100K" alt="Line chart with one red, one blue, and one green line">-->


