<?php
include_once '../class/class.MySQL.php';

$idcedis = $_POST['idcedis'];
$pasillo = $_POST['pasillo'];

$db = new MySQL();
$query = "SELECT 
    sku AS skuproducto, Descripcion AS desproducto
FROM
    productos
WHERE
    NOT EXISTS( SELECT 
            *
        FROM
            pasillos
        WHERE
            productos.sku = pasillos.IdPaquete
                AND IdPasillo = $pasillo
                AND iddeposito = $idcedis)
ORDER BY desproducto";
$result= $db->consulta($query);
$obj = $db->fetch_object($result);

$arr = array();

if($obj){
    do{
        $arr[] = array('skuproducto' => utf8_encode($obj->skuproducto),
                        'desproducto' => utf8_encode($obj->desproducto)); 
    }while($obj = $db->fetch_object($result));
}
echo ''.json_encode($arr).'';