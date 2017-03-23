<?php
if (!isset($_SESSION))
{
	session_start();
}
require_once('../clases/class.MySQL.php');
$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$fechaIni = $_POST['fechaIni'];
$fechaFin = $_POST['fechaFin'];
$tipoReporte = $_POST['tipoR'];

// reporte supervisor
if ($tipoReporte==0) {

	include('reporteSupervisorXLS.php');
}

// reporte vendedor
elseif ($tipoReporte==1) {

	include('reporteOperadorEntregaPDF.php');
}

// reporte bodega
elseif ($tipoReporte==2) {

	include('reporteBodegaPDF.php');
}

elseif ($tipoReporte==3) {

	include('reporteBodegaMXLS.php');
}

elseif ($tipoReporte==4) {

	include('reporteBodegaDXLS.php');
}

elseif ($tipoReporte==5) {

	include('reporteBodegaAPDF.php');
}

elseif ($tipoReporte==6) {

	include('reportesIndicadoresXLS.php');
}
elseif ($tipoReporte==7) {

	include('reportesIndicadoresSXLS.php');
}
elseif ($tipoReporte==8) {

	include('reportesIndicadoresMXLS.php');
}
elseif ($tipoReporte==9) {

	include('reportesIndicadoresPXLS.php');
}
?>
