<?php
require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$iddeposito = $_GET['id'];
$Hem = $_GET['Hem'];
$idR = $_GET['idR'];

$condicionHemisferio = NULL;
$condicionRuta = NUll;

// preguntamos si el valor de hemisferio es diferente a 0 (todos)
if($Hem!=0){

  $condicionHemisferio = "AND p.hemisferio = $Hem ";
}

// preguntamos si el valor ruta es diferente a 0 (todos)
if($idR!=0) {
  $condicionRuta = " AND p.idRuta = $idR";
}

$consulta = "SELECT deposito, latitud, longitud FROM deposito WHERE iddeposito = $iddeposito LIMIT 1";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

$deposito = "new google.maps.LatLng('".$row['latitud']."','".$row['longitud']."')";

//$consulta2 = "SELECT p.idRuta, p.Latitud, p.Longitud, p.hemisferio, p.secuencia, p.centro_latitud, p.centro_longitud FROM poligonos p INNER JOIN Operaciones o ON p.idoperacion = o.idoperacion AND o.idDeposito = $iddeposito AND p.hemisferio = $hemisferio INNER JOIN resumen_ruta rr ON  p.idRuta = rr.idRuta AND rr.iddeposito = $iddeposito AND rr.fechaoperacion = DATE_SUB(CURRENT_DATE,INTERVAL $intervalo DAY) ORDER BY p.idRuta,p.secuencia";
$consulta2 = "SELECT 
            p.idRuta,
            p.Latitud,
            p.Longitud,
            p.hemisferio,
            p.secuencia,
            p.centro_latitud,
            p.centro_longitud
        FROM
            poligonos p
                INNER JOIN
            Operaciones o ON p.idoperacion = o.idoperacion
                AND o.idDeposito = $iddeposito
                $condicionHemisferio
                $condicionRuta
        ORDER BY p.hemisferio, p.idRuta , p.secuencia";
$resultado2 = $mysqli->consulta($consulta2);
$row2 = $mysqli->fetch_assoc($resultado2);

$bandera = 0;

$arrayPoligono = array();
$arrayRuta = array();
$cadenaMarcador = NULL;
$cadenaRuta = NULL;
$cadenaColor = NULL;

$x=0;
$bandera=0;
do{

  if($bandera==0)
    {
      $cadena.="[";
      $bandera=1;
      $arrayRuta[$x] = $row2['idRuta'];
      $cadenaRuta .= "'".$row2['idRuta']."',";
      $cadenaMarcador .= "new google.maps.LatLng(".$row2['centro_latitud'].",".$row2['centro_longitud']."),";

    }
    else{
        if($row2['secuencia']==1){
          $arrayRuta[$x+1] = $row2['idRuta'];
          $cadenaRuta .= "'".$row2['idRuta']."',";
          $cadena = substr($cadena, 0,-1);
          $cadena .="]";
          $arrayPoligono[$x] = $cadena;
          $cadenaMarcador .= "new google.maps.LatLng(".$row2['centro_latitud'].",".$row2['centro_longitud']."),";
          $cadena = '[';
          $x++;
        }      

    }

   $cadena .= "new google.maps.LatLng(".$row2['Latitud'].",".$row2['Longitud']."),";
}while($row2 = $mysqli->fetch_assoc($resultado2));

$cadena = substr($cadena, 0,-1);
$cadenaMarcador = substr($cadenaMarcador, 0,-1);
$cadenaRuta = substr($cadenaRuta, 0,-1);

$cadena .="]";
$arrayPoligono[$x] = $cadena;


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mapa</title>
    <!-- CSS de Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <link href="css/mapas.css" rel="stylesheet" media="screen">
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script src="js/MarkerWithLabels.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Script de google maps -->
    <script>
      // This example creates a simple polygon representing the Bermuda Triangle.
      // Note that the code specifies only three LatLng coordinates for the
      // polygon. The API automatically draws a
      // stroke connecting the last LatLng back to the first LatLng.
      var mex = <?php echo $deposito;?>;
      var neighborhoods = [<?php echo $cadenaMarcador;?>];
      var markers = [];
      var iterator = 0;
      var rutas = [<?php echo $cadenaRuta;?>];

      function initialize() {
        var mapOptions = {
          zoom: 12,
          center: mex,
          mapTypeId: google.maps.MapTypeId.MAPS
        };

        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        // Define the LatLng coordinates for the polygon's path. Note that there's
        // no need to specify the final coordinates to complete the polygon, because
        // The Google Maps JavaScript API will automatically draw the closing side.
        <?php 

        for($y=0;$y<count($arrayPoligono);$y++){
        ?>
          //alert(<?php echo $y;?>);
          var bermudaTriangle<?php echo $y;?>;
          var triangleCoords<?php echo $y; ?> = <?php echo $arrayPoligono[$y]; ?>;
        <?php 
        }
        ?>

        <?php for($z=0;$z<count($arrayPoligono);$z++){?>

            //alert("<?php echo $arrayColorBackGround[$arrayRuta[$z]]; ?>");
            bermudaTriangle<?php echo $z?> = new google.maps.Polygon({
            paths: triangleCoords<?php echo $z?>,
            strokeColor: "#005EFF",
            strokeOpacity: 0.8,
            strokeWeight: 3,
            fillColor: "#8CE5F0",
            fillOpacity: 0.35,
          });

          bermudaTriangle<?php echo $z?>.setMap(map);
        <?php }?>
        /*** Agregando los marcadores para las rutas***/
         for (var i = 0; i < neighborhoods.length; i++) {
              setTimeout(function() {
              addMarker();
              }, i * 200);
          }

        function addMarker() {
          var contentString = rutas[iterator];
          var marker = new MarkerWithLabel({
                position: neighborhoods[iterator],
                map: map,
                draggable: false,
                raiseOnDrag: true,
                labelContent: contentString,
                labelAnchor: new google.maps.Point(21, 21),
                labelClass: "labels", // the CSS class for the label
                labelInBackGround: false,
                animation: google.maps.Animation.DROP,
                icon:'img/Esfera.png'
            });

              google.maps.event.addListener(marker, 'click', function() { 
          });

          iterator++;
        }  
        /*******************************************************************/       
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map-canvas">
    </div>
  </body>
</html>