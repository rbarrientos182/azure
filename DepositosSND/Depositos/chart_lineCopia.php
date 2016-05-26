<?php
/*header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

$idoperacion = $_GET['idoperacion'];

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$iddeposito = $_GET['iddeposito'];

$consulta = "SELECT
idRuta, 
firmaElectroncia,
salidaCedis,
ADDTIME(salidaCedis, traslado1Cliente) AS primer_cliente,
traslado1Cliente,
tiempoServicio,
tiempoTraslado,
trasladoUltimoCliente,
llegadaCedis,
tiempoCedis FROM resumen_ruta 
WHERE fechaOperacion = CURRENT_DATE AND iddeposito = $iddeposito AND tipoRuta = 6";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

do{
	$arrayFe = split(':', $row['firmaElectroncia']);
	$arraySc = split(':', $row['salidaCedis']);
	$arrayPc = split(':', $row['primer_cliente']);
	$cadena .= "['".$row['idRuta']."',"."'Tiempo en Cedis AM', new Date(0,0,0,".$arrayFe[0].",".$arrayFe[1].",".$arrayFe[2]."), new Date(0,0,0,".$arraySc[0].",".$arraySc[1].",".$arraySc[2].")],"."['".$row['idRuta']."',"."'Traslado 1er Cliente', new Date(0,0,0,".$arraySc[0].",".$arraySc[1].",".$arraySc[2]."), new Date(0,0,0,".$arrayPc[0].",".$arrayPc[1].",".$arrayPc[2].")],";

}while($row = $resultado->fetch_assoc());

$cadena = substr($cadena, 0, -1);  */
?>   


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>
    Gantt Chart Project Schedule Example - HTML5 jQuery Chart Plugin by jqChart
</title>
    <link rel="stylesheet" type="text/css" href="../../css/jquery.jqChart.css" />
    <link rel="stylesheet" type="text/css" href="../../css/jquery.jqRangeSlider.css" />
    <link rel="stylesheet" type="text/css" href="../../themes/smoothness/jquery-ui-1.10.4.css" />
    
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="js/jquery.mousewheel.js" type="text/javascript"></script>
    <script src="js/jquery.jqChart.min.js" type="text/javascript"></script>
    <script src="js/jquery.jqRangeSlider.min.js" type="text/javascript"></script>
    <!--[if IE]><script lang="javascript" type="text/javascript" src="../../js/excanvas.js"></script><![endif]-->
    
    <script lang="javascript" type="text/javascript">
        $(document).ready(function () {
            $('#jqChart').jqChart({
                title: { text: 'Project Schedule' },
                animation: { duration: 1 },
                shadows: {
                    enabled: true
                },
                series: [
                    {
                        type: 'gantt',
                        title: 'Alan',
                        data: [
                            ['Design', new Date(2010, 0, 1), new Date(2010, 0, 20)],
                            ['Development', new Date(2010, 0, 21), new Date(2010, 1, 15)],
                            ['Design', new Date(2010, 1, 16), new Date(2010, 1, 28)],
                            ['Development', new Date(2010, 2, 1), new Date(2010, 2, 20)],
                            ['Testing', new Date(2010, 2, 21), new Date(2010, 3, 10)]
                        ]
                    },
                    {
                        type: 'gantt',
                        title: 'Carrie',
                        data: [
                            ['Design', new Date(2010, 0, 21), new Date(2010, 1, 15)],
                            ['Development', new Date(2010, 1, 16), new Date(2010, 1, 28)],
                            ['Testing', new Date(2010, 2, 1), new Date(2010, 2, 20)]
                        ]
                    },
                    {
                        type: 'gantt',
                        title: 'Katie',
                        data: [
                            ['Design'],
                            ['Development', new Date(2010, 2, 21), new Date(2010, 3, 10)],
                            ['Testing', new Date(2010, 1, 16), new Date(2010, 1, 28)],
                            ['Testing', new Date(2010, 3, 11), new Date(2010, 4, 1)]
                        ]
                    }
                ]
            });
        });
    </script>

</head>
<body>
    <div>
        <div id="jqChart" style="width: 500px; height: 300px;">
        </div>
    </div>
</body>
</html>