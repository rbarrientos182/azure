<?php 
include_once '../class/class.MySQL.php';

$db = new MySQL();

$cedis = $_POST['cedis'];
$largotarima = $_POST['largotarima'];
$anchotarima = $_POST['anchotarima'];
$margen = $_POST['margen'];
$margen1 = $_POST['margen1'];
$tarima1 = $_POST['tarima1'];
$tarima2 = $_POST['tarima2'];
$tarima3 = $_POST['tarima3'];
$tarima4 = $_POST['tarima4'];
$tarima5 = $_POST['tarima5'];
$pcompleta = $_POST['pcompleta'];
$pbandera = $_POST['pbandera'];
$pescuadra = $_POST['pescuadra'];
$pcombinada = $_POST['pcombinada'];
$skug = $_POST['skug'];
$cpasillos = $_POST['cpasillos'];
$accion = $_POST['accion'];
$idpaletizador = $_POST['idpaletizador'];

if($accion==0){
    $query = "INSERT INTO paletizador 
    (iddeposito,largotarima,anchotarima,margen,margen1,tipotarima1,tipotarima2,tipotarima3,tipotarima4,tipotarima5,porcentaje_completa,porcentaje_bandera,porcentaje_escuadra,porcentaje_combinada,sku_garrafon,Calculo_X_Pasillos)
    VALUES ($cedis,$largotarima,$anchotarima,$margen,$margen1,'$tarima1','$tarima2','$tarima3','$tarima4','$tarima5',$pcompleta,$pbandera,$pescuadra,$pcombinada,'$skug',$cpasillos)";
    $result = $db->consulta($query);

}
elseif($accion==1){
    $query = "UPDATE paletizador SET largotarima=$largotarima, anchotarima=$anchotarima, margen=$margen, margen1=$margen1, tipotarima1='$tarima1',
    tipotarima2='$tarima2', tipotarima3='$tarima3', tipotarima4='$tarima4', tipotarima5='$tarima5', porcentaje_completa=$pcompleta, porcentaje_bandera=$pbandera,
    porcentaje_escuadra=$pescuadra, porcentaje_combinada=$pcombinada, sku_garrafon='$skug', Calculo_X_Pasillos=$cpasillos WHERE idpaletizador=$idpaletizador";
    $result = $db->consulta($query);
}

    echo "<script 'type=text/javascript'>";
    echo "location.href='../index.php?var1=1';"; 
    echo "</script>";  

