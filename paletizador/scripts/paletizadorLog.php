<?php
include_once '../class/class.MySQL.php';

$idcedis = $_POST['idcedis'];
$fecha = $_POST['fecha'];

$db = new MySQL();

$query = "SELECT 
idPaletizador_Log, 
Iddeposito, Fecha, 
Inicio, 
Fin,
CASE(Estatus) WHEN 1 THEN 'Iniciado' WHEN 2 THEN 'Con error' WHEN 3 THEN 'Terminado' END AS estatusPasillo  FROM paletizador_log WHERE Iddeposito=$idcedis AND fecha='$fecha'";
$result = $db->consulta($query);
$obj = $db->fetch_object($result);

$arr = array();

if($obj){
    do{
        $arr[] = array('idPaletizador_Log' => $obj->idPaletizador_Log,
                        'Iddeposito' => $obj->Iddeposito,
                        'Fecha' => $obj->Fecha,
                        'Inicio' => $obj->Inicio,
                        'Fin' => $obj->Fin,
                        'Estatus' => $obj->estatusPasillo); 
    }while($obj = $db->fetch_object($result));
}

echo ''.json_encode($arr).'';