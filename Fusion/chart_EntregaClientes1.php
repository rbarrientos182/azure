<?php
// Desactivar toda notificación de error
error_reporting(0);

header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

set_time_limit(0);

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();


$iddeposito = $_GET['iddeposito'];

$consulta = "SELECT 
    fechaoperacion,
    (SELECT 
            CONCAT(ELT(WEEKDAY(DATE_SUB(fechaoperacion,INTERVAL 1 DAY)) + 1,
                                'Lunes',
                                'Martes',
                                'Miercoles',
                                'Jueves',
                                'Viernes',
                                'Sabado',
                                'Domingo'))
        ) AS dia,
    FORMAT(AVG((clientescv / clientesProg) * 100),1) AS Efectividad_EntregaClientes
FROM
    resumen_ruta
WHERE
    iddeposito = $iddeposito
        AND fechaOperacion > DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
        AND tiporuta = 6
GROUP BY fechaoperacion , iddeposito
ORDER BY fechaOperacion";

$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

do{
    $cadena .= "'".$row['dia']."',";
    $fecha = explode('-', $row['fechaoperacion']);

    $fecharesta = $fecha[1]-1;
    $fecha[1] = $fecharesta;
    

    if($fecha[2]<10){
         $fecha[2] = substr($fecha[2],1);
    }

    $cadena2 .= $row['Efectividad_EntregaClientes'].",";
}while($row = $mysqli->fetch_assoc($resultado));

$cadena = substr($cadena, 0, -1);
$cadena2 = substr($cadena2, 0, -1);
?>
<!DOCTYPE HTML>
<html>
  <head>
        <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
        <script src="js/highcharts.js"></script>

        <script>
                    $(function () {
                        $('#container').highcharts({
                            title: {
                                text: 'Efectividad Entrega Clientes',
                                x: -20 //center
                            },
                            subtitle: {
                               // text: 'Source: WorldClimate.com',
                                x: -20
                            },
                            xAxis: {
                                categories: [<?php echo $cadena;?>]
                            },
                            yAxis: {
                                title: {
                                    text: 'Porcentaje'
                                },
                                plotLines: [{
                                    value: 0,
                                    width: 1,
                                    color: '#808080'
                                }]
                            },
                            tooltip: {
                                valueSuffix: '%'
                            },
                            legend: {
                                layout: 'vertical',
                                align: 'right',
                                verticalAlign: 'middle',
                                borderWidth: 0
                            },
                            series: [{
                                name: ' ',
                                data: [<?php echo $cadena2; ?>]
                            } ]
                        });
                    });
        </script>

        <link rel="stylesheet" type="text/css" href="css/stylegrafica.css">
  </head>
  <body>
      <div class='divGrafica' id="container"></div>
      <?php $mysqli->liberar($resultado);?>
  </body>
</html>