<?php
include_once '../class/class.MySQL.php';

$iddeposito = $_POST['iddeposito'];
$fecha = $_POST['fecha'];
$ruta = $_POST['ruta'];
$tarima = $_POST['tarima'];

$db = new MySQL();

$query = "SELECT 
    idArmadoTarimas, sku, cajas_sku
FROM
    gepp.armadotarimas
WHERE
    fecha = '$fecha'
        AND iddeposito = $iddeposito
        AND idruta = $ruta
        AND numerotarima=$tarima
ORDER BY sku";

$result = $db->consulta($query);
$obj = $db->fetch_object($result);

$arr = array();

if($obj){
    do{
        $arr[] = array('idArmadoTarimas' => $obj->idArmadoTarimas,
                       'sku' => $obj->sku,
                       'cajas_sku' => $obj->cajas_sku); 
    }while($obj = $db->fetch_object($result));
}
echo ''.json_encode($arr).'';