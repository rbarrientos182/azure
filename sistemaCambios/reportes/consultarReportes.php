<?php 
if (!isset($_SESSION)) 
{
	session_start();
}
require_once('../clases/class.MySQL.php');
$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];
$fechaPreventa = $_POST['fechaPre'];
$tipoReporte = $_POST['tipoR'];

// reporte supervisor 
if ($tipoReporte==0) {

	include('reporteSupervisorXLS.php');
}

// reporte vendedor
elseif ($tipoReporte==1) {

	include('reporteVendedorPDF.php');
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

	include('reporteBodegaXLS.php');
}

elseif ($tipoReporte==6) {

	include('reportesIndicadoresXLS.php');
}
?>