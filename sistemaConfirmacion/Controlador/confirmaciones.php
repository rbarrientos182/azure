<?php
date_default_timezone_set('America/Mexico_City');
require_once('../Modelo/class.Conexion.php');
require_once('../Modelo/class.Consultas.php');

$inicio = $_POST['inicio'];
$fin = $_POST['fin'];

$query = new Consultas();
$filas = $query->obtenerConfirmacion($inicio,$fin);

$stylesOpc = array('height2','width2 height2','','','');

foreach($filas as $fila) {

  $hora = compararHora($fila['dt_confirmacion'],$fila['dt_inicio_despacho'],$fila['dt_fin_despacho']);
  $colorConfirmacion = compararHoraColor($fila['dt_confirmacion'],$fila['dt_inicio_despacho'],$fila['dt_fin_despacho']);
  $styleAleatorio = rand(0,4);
  $jsondata[] = array('cedis' => $fila['deposito'],
                      'mensaje' => 'Estatus: ',
                      'statuscolor'=> $colorConfirmacion,
                      'hora'=> $hora,
                      'style'=> $stylesOpc[$styleAleatorio]);
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata);
exit();


function compararHora($confirmacion,$inicio,$fin){
  $hora = null;
  $datetime1 = date_create(date("H:i:s"));

  if ($confirmacion==0) {
    $hora = "En espera";
  }
  elseif ($inicio==0){

    $datetime2 = date_create(".$confirmacion.");
    $interval = date_diff($datetime1, $datetime2);
    $hora = $interval->format("%H:%i:%S");
  }
  elseif ($fin==0) {

    $datetime2 = date_create(".$inicio.");
    $interval = date_diff($datetime1, $datetime2);
    $hora = $interval->format('%H:%i:%S');
  }
  else {
    $hora = $fin;
  }
  return $hora;

}// fin de compararHora

function compararHoraColor($confirmacion,$inicio,$fin){
  $color = "#FFFFFF";
  $arrayGris = array("#7B7D7D","#626567","#4D5656","#424949");
  $arrayVerde = array( "#28FF01","#28DA08","#2FCB13","#20AC07");
  $arrayAzul = array("#0C26E4","#0D24C8","#06178E","#263CDA");
  $arrayNaranja = array("#DA7E26","#EB9E26","#FF9B00","#FF8700");

  if ($confirmacion==0) {
    $colorAleatorio = rand(0,3);
    $color = $arrayGris[$colorAleatorio];
  }
  elseif ($inicio==0) {
    $colorAleatorio = rand(0,3);
    $color = $arrayVerde[$colorAleatorio];
  }
  elseif ($fin==0) {
    $colorAleatorio = rand(0,3);
    $color = $arrayAzul[$colorAleatorio];
  }
  else {
    $colorAleatorio = rand(0,3);
    $color = $arrayNaranja[$colorAleatorio];
  }
  return $color;
}// fin de compararHoraColor
