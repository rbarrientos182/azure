<?php 
$mysqli = new mysqli('localhost','gepp','gepp','gepp');

if ($mysqli->connect_error) {
    die('Error de Conexión (' . $mysqli->connect_errno. ') '
         . $mysqli->connect_error);
  }

  $idRegion = $_GET['id'];

  $consulta = "SELECT d.deposito, d.latitud, d.longitud FROM Deposito d 
                INNER JOIN Zona z ON d.idZona = z.idZona INNER JOIN Region r ON r.idRegion = z.idRegion WHERE r.idRegion = ".$idRegion." ORDER BY deposito";
  $resultado = $mysqli->query($consulta);
  $row = $resultado->fetch_assoc();


  do{

     $cadena .= "new google.maps.LatLng(".$row['latitud'].",".$row['longitud']."),";
     $center = $row['latitud'].",".$row['longitud'];
     $titulos .= "'".$row['deposito']."'".",";

  }while($row = $resultado->fetch_assoc());

  $cadena = substr($cadena, 0,-1);
  $titulos = substr($titulos, 0,-1);


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Marker animations with <code>setTimeout()</code></title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
// If you're adding a number of markers, you may want to
// drop them on the map consecutively rather than all at once.
// This example shows how to use setTimeout() to space
// your markers' animation.

var mex = new google.maps.LatLng(<?php echo $center ?>);

var neighborhoods = [<?php echo $cadena;?>];
var neighborhoods2 = [<?php echo $titulos;?>];
var markers = [];
var iterator = 0;

var map;

function initialize() {
  var mapOptions = {
    zoom: 9,
    center: mex
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
          mapOptions);
}

function drop() {
  for (var i = 0; i < neighborhoods.length; i++) {
    setTimeout(function() {
      addMarker();
    }, i * 200);
  }
}

function addMarker() {
  markers.push(new google.maps.Marker({
    position: neighborhoods[iterator],
    map: map,
    draggable: false,
    title: neighborhoods2[iterator],
    animation: google.maps.Animation.DROP
  }));
  iterator++;
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body onload="drop()">
    <div id="map-canvas"></div>
  </body>
</html>