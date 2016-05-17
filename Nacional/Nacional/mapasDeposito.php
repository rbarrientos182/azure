<?php 
require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

$idZona = $_GET['id'];

$consulta = "SELECT d.iddeposito, d.deposito, d.latitud, d.longitud, o.idoperacion, ord.fecha
  FROM Deposito d
  INNER JOIN Operaciones o ON d.idDeposito = o.idDeposito
  LEFT JOIN Orden ord ON o.idoperacion = ord.idoperacion AND ord.fecha > CURRENT_DATE
  GROUP BY d.iddeposito
  ORDER BY deposito";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

do{

    $cadena .= "new google.maps.LatLng(".$row['latitud'].",".$row['longitud']."),";
    $titulos .= "'".$row['deposito']."'".",";
    $iddeposito .= $row['iddeposito'].",";

    if($row['fecha']!=NULL)
    {
        $img .= "'img/truck3orange.png',";
    }
    else{

        $img .= "'img/truck3green.png',";
    }

}while($row = $mysqli->fetch_assoc($resultado));

$cadena = substr($cadena, 0,-1);
$titulos = substr($titulos, 0,-1);
$iddeposito = substr($iddeposito, 0,-1);
$img = substr($img, 0,-1);
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

var mex = new google.maps.LatLng('23.045176','-102.425383');

var neighborhoods = [<?php echo $cadena;?>];
var neighborhoods2 = [<?php echo $titulos;?>];
var iddeposito = [<?php echo $iddeposito;?>]
var image = [<?php echo $img;?>];
var markers = [];
var iterator = 0;

var map;

function initialize() {

  //alert('entro a initialize '+markers.length);

  var mapOptions = {
    zoom: 5,
    center: mex
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
          mapOptions);

  
  //console.log('hizo click');
}

function drop() {

  //alert('entro a drop '+markers.length);

  for (var i = 0; i < neighborhoods.length; i++) {
    setTimeout(function() {
      addMarker();
    }, i * 200);

  }
}

function addMarker() {

  //alert('entro a addMarker '+markers.length);

  markers.push(new google.maps.Marker({
    position: neighborhoods[iterator],
    map: map,
    draggable: false,
    icon: image[iterator],
    title: neighborhoods2[iterator],
    animation: google.maps.Animation.DROP
  }));
  
  google.maps.event.addListener(markers[iterator], 'click', function(event) {
    //console.log('hizo click');
    placeMarker(event.latLng);
  });

  iterator++;
}

google.maps.event.addDomListener(window, 'load', initialize);


    </script>
  </head>
  <body onload="drop()">
    <div id="map-canvas"></div>
  </body>
</html>