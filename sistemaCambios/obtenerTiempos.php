<?php 
require_once('clases/class.Tiempos.php');

$time = new Tiempos();


//recibo informacion del concentrado tiempo
$rInformacion = $_POST['rInformacion'];
$eInformacion = $_POST['eInformacion'];
$cEspera = $_POST['cEspera'];


//creamos un array para guardar los datos a retornar

$array = array();

//obtener tiempo excedido

$iOptimo = $time->obtenerInicioOptimo($rInformacion);

$tExcedido = $time->obtenerDiferenciaHoras($iOptimo,$rInformacion);

//obtener diseño
$val1 = $time->obtenerDiferenciaHoras($rInformacion,$eInformacion);
$disenio = $time->obtenerDiferenciaHoras($cEspera,$val1);

//obtener tiempo total

$tTotal = $time->obtenerTiempoTotal($rInformacion,$disenio,$cEspera);

//guardamos todo en un array para devolverlo como json

$array[] = array('tExcedido' => $tExcedido , 'disenio' => $disenio, 'tTotal' => $tTotal );

echo ''.json_encode($array).'';
?>