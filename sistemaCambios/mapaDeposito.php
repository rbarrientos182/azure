<?php 
$mysqli = new mysqli('localhost','gepp','gepp','gepp');

if ($mysqli->connect_error) {
    die('Error de Conexión (' . $mysqli->connect_errno. ') '
         . $mysqli->connect_error);
  }

  $idDeposito = $_GET['id'];

  $consulta = "SELECT latitud, longitud FROM deposito WHERE idDeposito = ".$idDeposito;
  $resultado = $mysqli->query($consulta);
  $row = $resultado->fetch_assoc();
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

var cedis = new google.maps.LatLng(<?php echo $row['latitud']?>, <?php echo $row['longitud']?>);

var markers = [];
var iterator = 0;

var map;

function initialize() {
  var mapOptions = {
    zoom: 12,
    center: cedis
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
          mapOptions);
}

function drop() {
    setTimeout(function() {
      addMarker();
    }, 1 * 200);
  
}

function addMarker() {
  markers.push(new google.maps.Marker({
    position: cedis,
    map: map,
    draggable: false,
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