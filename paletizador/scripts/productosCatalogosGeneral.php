<?php
include_once '../class/class.MySQL.php';

$db = new MySQL();
$query = "SELECT 
    sku AS skuproducto, Descripcion AS desproducto
FROM
    productos
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