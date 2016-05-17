<?php 
include_once('clases/class.CambiosMotivos.php');

$cMotivos = new CambiosMotivos();

$valor = $_POST['valor'];

$cMotivos->delCambiosMotivos($valor);
$cMotivos->mostrarTabla();
?>