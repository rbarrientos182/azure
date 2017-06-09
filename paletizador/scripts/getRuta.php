<?php
include_once '../class/class.MySQL.php';



$db = new MySQL();

$iddeposito = $_POST['iddeposito'];
$fecha = $_POST['fecha'];

$query = "SELECT 
    idruta
FROM
    gepp.armadotarimas
WHERE
    fecha = '$fecha'
    AND iddeposito=$iddeposito
GROUP BY idruta
ORDER BY idruta";
$result = $db->consulta($query);
$obj = $db->fetch_object($result);

$arr = array();

if($obj){
    do{
        $arr[] = array('idruta' => $obj->idruta); 
    }while($obj = $db->fetch_object($result));
}
echo ''.json_encode($arr).'';