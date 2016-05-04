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

?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple markers</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
    function initialize() {
     var myLatlng = new google.maps.LatLng(20.673644, -103.34382);
      var mapOptions = {
        zoom: 12,
        center: myLatlng
      }
      var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

      <?php 
      do{
      ?>
      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(<?php echo $row['latitud'];?>, <?php echo $row['longitud'];?>),
          map: map,
          animation: google.maps.Animation.DROP,
          title: '<?php echo $row['nombre']; ?>'
      });

      google.maps.event.addListener(marker, 'click', toggleBounce);

      <?php
      }while($row = $resultado->fetch_assoc());
       ?>


    }

    function toggleBounce() {

      if (marker.getAnimation() != null) {
        marker.setAnimation(null);
      } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
      }
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

