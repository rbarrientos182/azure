<?php
include_once '../class/class.MySQL.php';



$db = new MySQL();

$iddeposito = $_POST['iddeposito'];
$fecha = $_POST['fecha'];
$ruta = $_POST['ruta'];

$query = "SELECT 
    numerotarima, tipotarima, SUM(cajas_sku) AS totalcajas
FROM
    gepp.armadotarimas
WHERE
    fecha = '$fecha'
        AND iddeposito = $iddeposito
        AND idruta = $ruta
GROUP BY numerotarima , tipotarima
ORDER BY numerotarima , tipotarima";
$result = $db->consulta($query);
$obj = $db->fetch_object($result);

$arr = array();

if($obj){
    do{
        $arr[] = array('numerotarima' => $obj->numerotarima,
                       'tipotarima' => $obj->tipotarima,
                       'totalcajas' => $obj->totalcajas); 
    }while($obj = $db->fetch_object($result));
}
echo ''.json_encode($arr).'';