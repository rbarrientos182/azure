<?php
include_once '../class/class.MySQL.php';

$iddeposito = $_POST['iddeposito'];
$fecha = $_POST['fecha'];
$ruta = $_POST['ruta'];
$tarima = $_POST['tarima'];

$db = new MySQL();

$query = "SELECT
    idArmadoTarimas, a.sku AS skup, Descripcion, cajas_sku
FROM
    gepp.armadotarimas AS a INNER JOIN gepp.productos AS p ON a.sku = p.sku
WHERE
    fecha = '$fecha'
        AND iddeposito = $iddeposito
        AND idruta = $ruta
        AND numerotarima = $tarima
ORDER BY a.sku";

$result = $db->consulta($query);
$obj = $db->fetch_object($result);

$arr = array();

if($obj){
    do{
        $arr[] = array('idArmadoTarimas' => $obj->idArmadoTarimas,
                       'sku' => $obj->skup,
                       'descripcion' => utf8_encode($obj->Descripcion),
                       'cajas_sku' => $obj->cajas_sku);
    }while($obj = $db->fetch_object($result));
}
echo ''.json_encode($arr).'';
