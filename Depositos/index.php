<?php
$iddeposito = $_GET['iddeposito'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cambio de Sitio</title>
  </head>
  <body style="background-color:#B2FFFF">
    <center>
      <img src="http://i.imgur.com/KOROir5.png" alt="logo pepsi">
      <br>
      <br>
      <br>
      <br>
      <h2>Lo sentimos, el sitio ha sido movido a otro servidor.
        Favor de ponerte en contacto con tu TI.
        <br>
        Espere por favor mientras es redirigido</h2>
    </center>
    <script type="text/javascript">
        var iddeposito = <?php echo $iddeposito; ?>;
        function r() {
          location.href="http://192.168.21.29/depositos.php?iddeposito="+iddeposito;
        }
        setTimeout ("r()", 5000);
    </script>
  </body>
</html>
