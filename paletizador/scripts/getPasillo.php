<?php
include_once '../class/class.MySQL.php';



$db = new MySQL();

$iddeposito = $_POST['idcedis'];



$query = "SELECT * FROM gepp.pasillos WHERE iddeposito = $iddeposito GROUP BY idpasillo ORDER BY idpasillo DESC LIMIT 1";
$result = $db->consulta($query);
$obj = $db->fetch_object($result);

if($obj){
    $pasillo = $obj->IdPasillo + 1;
}
else{
    $pasillo = 1;
}

//echo ''.json_encode( $pasillo).'';
$arr = array();

$arr[] = array('pasillo' => $pasillo);

echo ''.json_encode($arr).'';