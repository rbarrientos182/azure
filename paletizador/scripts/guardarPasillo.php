<?php 
include_once '../class/class.MySQL.php';

$db = new MySQL();

$skus = explode(',',$_POST['sku']); // convierto el string a un array.
$pasillo = $_POST['pasillo'];
$nocedis = $_POST['nocedis'];

$query = "DELETE FROM pasillos WHERE iddeposito = $nocedis AND IdPasillo = $pasillo";
$db->consulta($query);


for ($i=0; $i < COUNT($skus) ; $i++) { 
    $query2 = "INSERT INTO pasillos (iddeposito,IdPasillo,IdPaquete) VALUES ($nocedis,$pasillo,$skus[$i])";
    $db->consulta($query2);
}

echo 1;