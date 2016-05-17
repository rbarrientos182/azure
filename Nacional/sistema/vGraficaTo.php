<?php 
if (!isset($_SESSION)) 
{
	session_start();
}

require_once('clases/class.Graficas.php');
require_once('clases/class.PromedioGrafica.php');


$grafica = new Graficas();
$pGrafica = new PromedioGrafica();


$nSemana = $_POST['nSemana'];
$tOperacion = $_POST['tOperacion'];
$iddeposito = $_SESSION['idDeposito'];


/*** Mandamos a llamar a nuestro setters de nSemana, idDeposito y tOperacion ***/
$pGrafica->setNSemana($nSemana);
$pGrafica->setIdDesposito($iddeposito);
$pGrafica->setToperacion($tOperacion);
/*** ***/

//asignamos propiedades de las graficas
$grafica->titulografica = "Tiempos de Operación";
$grafica->dimensiones = "1000x300";
$grafica->coloresdebarras = "1f497d,fffc00,ff0000,92d050"; //colores para la gráfica de barras


//$grafica->y1 = $pGrafica->obtenerRangoY($vMin,$vMax);
//echo "<br>";
$grafica->y2="|Hora Promedio|";

$inicioOptimo = $pGrafica->obtenerInicioOptimo();
$colaEspera = $pGrafica->obtenerColadeEspera();
$tiempoExcedido = $pGrafica->obtenerTiempoExcedido();
$disenio = $pGrafica->obtenetTiempoDisenio();


$grafica->valores = $inicioOptimo."|".$colaEspera."|".$tiempoExcedido.'|'.$disenio;

echo $dia = $pGrafica->obtenerRangoDiaTo();
echo '<br>';
$grafica->x1= $dia;
$grafica->x2="|Semana ".$nSemana."|";

//echo 'el valor minimo de la grafica es '.$pGrafica->vMin;
//echo 'el valor maximo de la grafica es '.$pGrafica->vMax;

//$grafica->vMin = $pGrafica->vMin;
//$grafica->vMax = $pGrafica->vMax;

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
<!--<img src="<?php //echo $grafica->unaFuncion();?>" alt="Estadisticas"/>-->
<!--<img src="https://chart.googleapis.com/chart?chtt=Estadistícas&cht=lc&amp;chco=2362A1,00FF00,0000FF&amp;chs=1000x300&amp;chd=s:FOETHECat,lkjtf3asv,KATYPSNXJ&amp;chxt=x,y&amp;chxl=0:|Oct|Nov|Dec|1:||20K||60K||100K" alt="Line chart with one red, one blue, and one green line">-->


