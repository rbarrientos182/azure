<?php
include_once '../class/class.MySQL.php';

$idcedis = $_POST['idcedis'];
$pasillo = $_POST['pasillo'];

$db = new MySQL();
$query = "SELECT pa.IdPaquete AS skuproducto, p.Descripcion AS desproducto FROM pasillos AS pa
INNER JOIN productos AS p ON pa.IdPaquete = p.sku  WHERE IdPasillo = $pasillo AND iddeposito = $idcedis  ORDER BY sku";
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
