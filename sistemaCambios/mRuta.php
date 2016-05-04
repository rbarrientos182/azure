<?php 
require_once('clases/class.MySQL.php');

$db = new MySQL();

$id = $_POST['id'];
$ruta = $_POST['ruta'];
$tipoR = $_POST['tipoR'];
$estatusR = $_POST['estatusR'];
$tipoM = $_POST['tipoM'];
$nGrupo = $_POST['nGrupo'];

$consulta = "UPDATE rutasCambios SET idgruposupervision = $nGrupo,  ruta = $ruta, tipo = $tipoR, estatus = $estatusR, tMercado = $tipoM WHERE idrutasCambios = $id";
$db->consulta($consulta);

header('Location: rutas.php')
?>