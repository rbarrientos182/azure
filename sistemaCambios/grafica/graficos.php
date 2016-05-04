<?php

if (!isset($_SESSION)) 
{
  session_start();
}
require_once("../clases/class.MySQL.php");

$db = new MySQL();

$idoperacion = $_SESSION['idoperacion'];

$fechaDe = $_GET['fechaDe'];
$fechaPara = $_GET['fechaPara'];
$jt = $_GET['jt'];
$seg = $_GET['seg'];
$mot = $_GET['mot'];
$condicionJT = NULL;
$condicionSeg = NULL;
$condicionMo = NULL;

if($jt!=0){
    $condicionJT = " AND u.NumEmpleado = $jt ";
}

if($eg!=0){

    $condicionSeg = " AND p.Segmento = '$seg' ";
}

if($mot!=0){
    $condicionMo = " AND cc.idCambiosMotivos = $mot ";
}

if($opcion==1){
    $nombre = " UPPER(cm.Descripcion) AS motivo,";

}
elseif($opcion==2){
    $nombre = " UPPER(u.Nombre) AS nombre,";

}
/** Consulta para motivos graficos**/
$consultaMo = "SELECT 
    ".$nombre."
    SUM(cc.cantidad) AS piezassolicitadas
FROM
    usrcambios u
        INNER JOIN
    gruposupervision gs ON u.NumEmpleado = gs.NumEmpleado
        INNER JOIN
    rutascambios rc ON gs.idgruposupervision = rc.idgruposupervision
        INNER JOIN
    usrcambios u2 ON rc.ruta = u2.ppp
        INNER JOIN
    capturacambios cc ON u2.NumEmpleado = cc.NumEmpleado
        INNER JOIN
    productoscambios pc ON cc.idproductocambio = pc.idProductoCambio
        INNER JOIN
    productos p ON pc.sku = p.sku
        INNER JOIN 
    cambiosmotivos cm ON cc.idCambiosMotivos = cm.idCambiosMotivos
    WHERE cc.idoperacion = $idoperacion AND cc.FechaCambio BETWEEN '$fechaDe' AND '$fechaPara' $condicionJT $condicionMo $condicionSeg GROUP BY cc.idCambiosMotivos";
$resultadoMo = $db->consulta($consultaMo);
$rowMo = $db->fetch_assoc($resultadoMo);
/** Se arma graficos **/
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Circles</title>
    <link rel="stylesheet" type="text/css" href="../css/stylecharts.css">
    <script>window.jQuery || document.write('<script src="../js/jquery-1.7.2.min.js"><\/script>')</script>
    <script src="../js/highcharts.js"></script>
    <script src="../js/highcharts-more.js"></script>
    <script src="../js/exporting.js"></script>
    <script type="text/javascript">
        $(function () {

            // Radialize the colors
            Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
                return {
                    radialGradient: {
                        cx: 0.5,
                        cy: 0.3,
                        r: 0.7
                    },
                    stops: [
                        [0, color],
                        [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                    ]
                };
            });

            // Build the chart
            $('#div1').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Grafica por Segmento'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            },
                            connectorColor: 'silver'
                        }
                    }
                },
                series: [{
                    name: "Brands",
                    data: [
                        {name: "Microsoft Internet Explorer", y: 56.33},
                        {
                            name: "Chrome",
                            y: 24.03,
                            sliced: false,
                            selected: false
                        },
                        {name: "Firefox", y: 10.38},
                        {name: "Safari", y: 4.77}, {name: "Opera", y: 0.91},
                        {name: "Proprietary or Undetectable", y: 0.2}
                    ]
                }]
            });
        });
    </script>
</head>
<body>
    <div id="contenedor1" class="div">
        <div id="div1" class="div div2">
            5858
        </div>

        <div id="div2" class="div div2">
            4554654
        </div>
    </div>  
    <div id="contenedor2" class="div">  
        <div id="div3" class="div div2">
            4564564            
        </div>

        <div id="div4" class="div div2">
            45645645
        </div>
    </div>    
  <!--<div id="container" style="background-color:#00ff00;min-width: 310px; height: 600px; max-width: 800px; margin: 0 auto"></div>-->
</body>
</html>