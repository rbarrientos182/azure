<?php
// Desactivar toda notificación de error
error_reporting(0);


$iddeposito = $_GET['iddeposito'];

/**comprueba la hora **/
/*echo "Hora Actual: " .date("H:i:s") . "<br />"; 
echo "-1 hora: ".date("H:i:s",strtotime("-6 hour"));*/

if(date("H:i:s",strtotime("-6 hour")) < 15){

header('Location: ../Fusion/tablaRutas2.php?iddeposito='.$iddeposito);


}

require_once("clases/class.MySQL.php");

$mysqli = new MySQL();

//Consulta para obtener el geocodigo del deposito y centrar en google maps
$consulta = "SELECT deposito, latitud, longitud FROM deposito WHERE iddeposito = $iddeposito LIMIT 1";
$resultado = $mysqli->consulta($consulta);
$row = $mysqli->fetch_assoc($resultado);

$deposito = "new google.maps.LatLng('".$row['latitud']."','".$row['longitud']."')";


/** comprueba la fecha y obtiene que numero de dia es **/
$fecha = date('Y-m-j');
$nuevafecha = strtotime ('-6 hour',strtotime ($fecha));
$nuevafecha = date ('Y-m-j', $nuevafecha );
$diaSemana =  date('w',$nuevafecha);

if($diaSemana==2 || $diaSemana==4 || $diaSemana==6){

  $hemisferio = 1;

}

elseif ($diaSemana==3 || $diaSemana==5 || $diaSemana==7 ) {
  $hemisferio = 2;

}

//consulta para obtener los poligonos de las rutas de acuerdo al hemisferio que toca
$consulta2 = "SELECT p.idRuta, p.Latitud, p.Longitud, p.hemisferio, p.secuencia, p.centro_latitud, p.centro_longitud FROM poligonos p INNER JOIN Operaciones o ON p.idoperacion = o.idoperacion AND o.idDeposito = $iddeposito AND p.hemisferio = $hemisferio INNER JOIN resumen_ruta rr ON  p.idRuta = rr.idRuta AND rr.iddeposito = $iddeposito AND rr.fechaoperacion = CURRENT_DATE ORDER BY p.idRuta,p.secuencia";
$resultado2 = $mysqli->consulta($consulta2);
$row2 = $mysqli->fetch_assoc($resultado2);

$bandera = 0;

$arrayPoligono = array();
$arrayRuta = array();
$cadenaMarcador = NULL;
$cadenaRuta = NULL;

$x=0;
$bandera=0;
do{

  if($bandera==0)
    {
      $cadena.="[";
      $bandera=1;
      $arrayRuta[$x] = $row2['idRuta'];
      $cadenaRuta .= $row2['idRuta'].',';
      $cadenaMarcador .= "new google.maps.LatLng(".$row2['centro_latitud'].",".$row2['centro_longitud']."),";
    }
    else{
        if($row2['secuencia']==1){
          $arrayRuta[$x+1] = $row2['idRuta'];
          $cadenaRuta .= $row2['idRuta'].',';
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

$arrayColorBackGround = array();
$cadenaColor = NULL;

/**Consulta para obtener las efectividades**/
$consulta3 = "SELECT 
      r.idruta,
      IF(ISNULL(nudsvnp),0,nudsvnp) AS pppVNP,
      IF(ISNULL(clientesVNP),0,clientesVNP) AS vppVNP,
      CONCAT(FORMAT((r.clientesvp/r.clientesProg) * 100,1),'%') AS Efectividad_Visita,
      CONCAT(FORMAT((r.clientescv/r.clientesProg) * 100,1),'%') AS Efectividad_EntregaClientes,
      CONCAT(FORMAT((r.cajasef/r.cajaspfp) * 100,1),'%') AS Efectividad_EntregaCajas,
      IF(FORMAT((r.clientesvp/r.clientesProg) * 100,1)<98,'rRojo','rVerde') AS classEfectividadVisita,
      IF(FORMAT((r.clientescv/r.clientesProg) * 100,1)<98,'rRojo','rVerde') AS classEntregaClientes,
      IF(FORMAT((r.cajasef/r.cajaspfp) * 100,1)<98,'rRojo',IF(FORMAT((r.cajasef/r.cajaspfp) * 100,1)<100,'rVerde','rAmarillo')) AS classEntregaCajas
      FROM resumen_ruta r 
      LEFT JOIN (
      SELECT b.iddeposito AS iddeposito, fecha, idruta, km, COUNT(nud) AS paradas, SUM(cfisicas) AS cajasFisicas, SUM(csio) AS cajassio 
      FROM orden a 
      INNER JOIN operaciones b ON a.idoperacion = b.idoperacion 
      WHERE fecha = CURRENT_DATE AND iddeposito = $iddeposito 
      GROUP BY idruta
      ) a ON a.iddeposito = r.iddeposito AND a.fecha = r.fechaoperacion  AND r.idruta = a.idruta
      LEFT JOIN (
      SELECT d.iddeposito, vpp, 
      COUNT(o.nud) nudsvnp 
      FROM orden o 
      INNER JOIN operaciones op ON op.idoperacion = o.idoperacion
      INNER JOIN deposito d ON d.iddeposito = op.iddeposito
      INNER JOIN clientes c ON o.nud = c.nud AND c.iddeposito = d.idDeposito
      WHERE dia NOT LIKE CONCAT('%',(SELECT CONCAT(ELT(WEEKDAY(fecha_preventa) + 1, 'L', 'M', 'R', 'J', 'V', 'S', 'D'))),'%') AND c.iddeposito = $iddeposito
      AND fecha = CURRENT_DATE 
      GROUP BY d.idDeposito, vpp
      ) ffrec ON ffrec.iddeposito = r.iddeposito AND ffrec.vpp = r.idruta 
      WHERE r.iddeposito = $iddeposito AND r.fechaOperacion = CURRENT_DATE AND tiporuta = 6";
      $resultado3 = $mysqli->consulta($consulta3);
      $row3 = $mysqli->fetch_assoc($resultado3);
      do{

          if ($row3['classEfectividadVisita']=='rRojo') {
            $color = '#ff0000';
          }
          else{

            $color = '#00ff30'; 
          }

           $arrayColorBackGround[$row3['idruta']] = $color;

        }while($row3 = $mysqli->fetch_assoc($resultado3));
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
    <script>
      // This example creates a simple polygon representing the Bermuda Triangle.
      // Note that the code specifies only three LatLng coordinates for the
      // polygon. The API automatically draws a
      // stroke connecting the last LatLng back to the first LatLng.

      setTimeout(function(){
            $(location).attr('href','mapasDepositoEntregaC.php?iddeposito='+<?php echo $iddeposito;?>);
      },60000);

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
            strokeColor: "<?php echo $arrayColorBackGround[$arrayRuta[$z]]; ?>",
            strokeOpacity: 0.8,
            strokeWeight: 3,
            fillColor: "<?php echo $arrayColorBackGround[$arrayRuta[$z]]; ?>",
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
    <!--Script de paginacion tabla -->
    <script type="text/javascript">
      var limit = 17; // variable limite para la paginacion
      var iddeposito = <?php echo $iddeposito; ?>;
      $(document).ready(
        function ()
        {
          //alert(iddeposito);

          $.ajax({
            url:"obtenerRegistroRutas.php",
            data:'iddeposito='+iddeposito+'&tipoRuta=6',
            type:'POST',
            cache:false,
            success:function function_name (nRegistro) {
              //alert(nRegistro);
              paginarTabla2(nRegistro,0,limit,iddeposito);
              

            },
            error: function function_name (request,error) {
              console.log("Pasó lo siguiente: "+error);
                    //alert("Pasó lo siguiente: "+error);
            },
          });
         
        }//fin function
      );

      function paginarTabla2(cuantos,inicio,fin,iddeposito) 
      {
        //alert('cuantos '+cuantos+' inicio '+inicio+' fin '+fin+' iddeposito'+iddeposito);

        if(inicio>=cuantos){

          inicio = 0;
          fin = 0;
            
          fin = limit;
        }

        $("#formContent").load("rutasMapasVpp.php",{inicio:inicio, fin:limit, iddeposito:iddeposito}, function(response, status, xhr) {
            if(status == "error") {
                    var msg = "Error!, algo ha sucedido: ";
                    $("#formContent").html(msg + xhr.status + " " + xhr.statusText);
                }
                else if(status == "success"){
                  inicio = fin;
              fin = fin+limit;
                setTimeout(function(){
              paginarTabla2(cuantos,inicio,fin,iddeposito);
              },10000);
                }
          }); 
      }
    </script>
  </head>
  <body>
    <div id="map-canvas">
    </div>
    <div id="formLabel">
      Efectividad Visita
    </div>
    <div id="formContent">+
    <?php
      $resultado3 = $mysqli->consulta($consulta3);
      $row3 = $mysqli->fetch_assoc($resultado3);
      ?>
      <table id="tabla" class="table table-condensed table-bordered">
      <thead>
        <tr> 
          <th colspan="4" class="text-center">Servicio</th>
        </tr>
        <tr >
          <th class="text-center">Ruta</th>
          <th class="text-center">Efectividad<br> Visita</th>
          <th class="text-center">Efectividad <br>Entrega Clientes</th>
          <th class="text-center">Efectividad <br>Entrega Cajas</th>
        </tr>
      </thead>
      <tbody>
        <?php
        do{
        ?>
          <tr>
            <td><?php echo $row3['idruta'];?></td>
            <td class="<?php echo $row3['classEfectividadVisita']?>"><?php echo $row3['Efectividad_Visita'];?></td>
            <td class="<?php echo $row3['classEntregaClientes']?>"><?php echo $row3['Efectividad_EntregaClientes'];?></td>
            <td class="<?php echo $row3['classEntregaCajas']?>"><?php echo $row3['Efectividad_EntregaCajas'];?></td>
          </tr>
        <?php 
        }while($row3 = $mysqli->fetch_assoc($resultado3));
        $mysqli->liberar($resultado3);
        ?>
      </tbody>  
    </table>
    </div>
  </body>
</html>