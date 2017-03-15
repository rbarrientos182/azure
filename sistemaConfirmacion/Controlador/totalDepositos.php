<?php
require_once('../Modelo/class.Conexion.php');
require_once('../Modelo/class.Consultas.php');

$query = new Consultas();
$total = $query->obtenerTotalDepositos();
echo $total;
