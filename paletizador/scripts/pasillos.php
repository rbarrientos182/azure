<?php
include_once '../class/class.MySQL.php';

$idcedis = $_POST['idcedis'];

$db = new MySQL();
$query = "SELECT * FROM pasillos WHERE iddeposito = $idcedis GROUP BY idpasillo ORDER BY idpasillo";
$result= $db->consulta($query);
$obj = $db->fetch_object($result);

$arr = array();

if($obj){
    do{
        $arr[] = array('idPasillos' => $obj->idPasillos,
                        'iddeposito' => $obj->iddeposito,
                        'IdPasillo' => $obj->IdPasillo); 
    }while($obj = $db->fetch_object($result));
}

echo ''.json_encode($arr).'';