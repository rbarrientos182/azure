<?php 

$mysqli = new mysqli('localhost','gepp','gepp','gepp');

if ($mysqli->connect_error) {
    die('Error de Conexión (' . $mysqli->connect_errno. ') '
         . $mysqli->connect_error);
  }

  $consulta = "SELECT d.deposito, c.nombre, c.direccion, CONCAT(c.calleizq,' y ',c.calleder) AS cruce, c.latitud, c.longitud FROM Clientes c 
                INNER JOIN Deposito d ON d.idDeposito = c.idDeposito WHERE d.idDeposito = 825 ORDER BY nombre LIMIT 1, 25";
  $resultado = $mysqli->query($consulta);
  $row = $resultado->fetch_assoc();


  do{

     $cadena .= " new google.maps.LatLng(".$row['latitud'].",".$row['longitud']."),";

  }while($row = $resultado->fetch_assoc());

  $cadena = substr($cadena, 0,-1);


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

var mex = new google.maps.LatLng(19.433333, -99.133333);

var neighborhoods = [<?php echo $cadena;?>];

var markers = [];
var iterator = 0;

var map;

function initialize() {
  var mapOptions = {
    zoom: 12,
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
    animation: google.maps.Animation.DROP
  }));
  iterator++;
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body onload="drop()">
    <div id="panel" style="margin-left: -52px">
      <button id="drop">Drop Markers</button>
     </div>
    <div id="map-canvas"></div>
  </body>
</html>