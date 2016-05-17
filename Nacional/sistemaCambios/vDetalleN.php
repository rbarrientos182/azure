<?php 
if (!isset($_SESSION)) 
{
	session_start();
}

//echo 'entro a archivo vDetallN.php';
require_once('clases/class.PromedioGrafica.php');

$pGrafica = new PromedioGrafica();


$nSemana = $_POST['nSemana'];
$tDetallado = $_POST['tDetallado'];
$tOperacion = $_POST['tOperacion'];
$iddeposito = $_SESSION['idDeposito'];


/*** Mandamos a llamar a nuestro setters de nSemana, idDeposito y tOperacion ****/
$pGrafica->setNSemana($nSemana);
$pGrafica->setIdDesposito($iddeposito);
$pGrafica->setToperacion($tOperacion);
/*** ***/


/*** Obtenemos el valor del detallado númerico de deseamos ***/

if ($tDetallado==0){
	$tabla = $pGrafica->obtenerTablaRutasProgramadas();

}

elseif($tDetallado==1) {
	
	$tabla = $pGrafica->obtenerTablaVisitasProgramadas();
	
}
elseif ($tDetallado==2) {

	$tabla = $pGrafica->obtenerTablaEfectividadVisita();
	
}
elseif ($tDetallado==3) {
	$tabla = $pGrafica->obtenerTablaEfectividadCliente();
	
}
elseif ($tDetallado==4) {

	$tabla = $pGrafica->obtenerTablaEfectividadCajas();
	
}
elseif ($tDetallado==5) {
	$tabla = $pGrafica->obtenerCapacidadCamion();
}
elseif ($tDetallado==6) {
	$tabla = $pGrafica->obtener2Cajas();
}

?>

<table class="table table-striped table-bordered bootstrap-datatable datatable">
	<?php echo $tabla;?>
</table>


