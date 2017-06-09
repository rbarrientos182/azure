<?php
include_once '../class/class.MySQL.php';

$idcedis = $_POST['idcedis'];

$db = new MySQL();

$query = "SELECT * FROM paletizador WHERE iddeposito = $idcedis LIMIT 1";
$result = $db->consulta($query);
$obj = $db->fetch_object($result);

$arr = array();

if($obj){
    do{
        $arr[] = array('idpaletizador' => $obj->idpaletizador,
                        'iddeposito' => $obj->iddeposito,
                        'largotarima' => $obj->largotarima,
                        'anchotarima' => $obj->anchotarima,
                        'margen' => $obj->margen,
                        'margen1' => $obj->margen1,
                        'tipotarima1' => $obj->tipotarima1,
                        'tipotarima2' => $obj->tipotarima2,
                        'tipotarima3' => $obj->tipotarima3,
                        'tipotarima4' => $obj->tipotarima4,
                        'tipotarima5' => $obj->tipotarima5,
                        'porcentaje_completa' => $obj->porcentaje_completa,
                        'porcentaje_bandera' => $obj->porcentaje_bandera,
                        'porcentaje_escuadra' => $obj->porcentaje_escuadra,
                        'porcentaje_combinada' => $obj->porcentaje_combinada,
                        'sku_garrafon' => $obj->sku_garrafon,
                        'calculo_pasillo' => $obj->Calculo_X_Pasillos,
                        'action' => '1'); 
    }while($obj = $db->fetch_object($result));
}
else{
    $arr[] = array('idpaletizador' => '',
                        'iddeposito' => '',
                        'largotarima' => '',
                        'anchotarima' => '',
                        'margen' => '',
                        'margen1' => '',
                        'tipotarima1' => '',
                        'tipotarima2' => '',
                        'tipotarima3' => '',
                        'tipotarima4' => '',
                        'tipotarima5' => '',
                        'porcentaje_completa' => '',
                        'porcentaje_bandera' => '',
                        'porcentaje_escuadra' => '',
                        'porcentaje_combinada' => '',
                        'sku_garrafon' => '',
                        'calculo_pasillo' => '',
                        'action' => '0'); 
}


echo ''.json_encode($arr).'';