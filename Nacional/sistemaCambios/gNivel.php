<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();

$nivel = $_POST['nivel'];
$descripcion = $_POST['descripcion'];

$consulta = "INSERT INTO Nivel (nivel,descripcion) VALUES ('$nivel','$descripcion')";
$db->consulta($consulta);

header('Location: niveles.php')

?>