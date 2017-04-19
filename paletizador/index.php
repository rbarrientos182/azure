<?php
include_once 'controladores/class.Paletizador.php';

$pal = new Paletizador();



?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head
    content must come *after* these tags -->
  	<meta name="description" content="Distribución Pepsi">
  	<meta name="author" content="Roberto Barrientos">
    <title>Paletizador</title>
    <link rel="shortcut icon" href="img/loguito.png">
    <link href="css/jquery-ui.min.css" rel="stylesheet" >
    <link href="css/jquery-ui.structure.min.css" rel="stylesheet" >
    <link href="css/jquery-ui.theme.min.css" rel="stylesheet" >
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet" >
    <link href="css/animate.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <h1>Configuración</h1>
        <div class="col-md-10">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#paletizador" data-toggle="tab">Paletizador</a></li>
              <li><a href="#pasillos" data-toggle="tab">Pasillos</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="paletizador">
                <form role="form" class="form-horizontal" action="" method="post">
                    <div class="box-body">
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="exampleInputEmail1">CEDIS</label>
                          <div class="col-sm-8">
                            <select class="form-control" name="cedis">

                                <option value=""></option>
                            </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">CEDIS</label>
                        <div class="col-sm-8">
                          <input type="text" name="" value="">
                          <input type="text" name="" value="">
                          <input type="text" name="" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1"></label>
                        <div class="col-sm-8">
                          <input type="text" name="" value="">
                          <input type="text" name="" value="">
                          <input type="text" name="" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                          <button type="submit" class="btn btn-default">Guardar</button>
                          <button type="reset" class="btn btn-default">Cancelar</button>
                        </div>
                      </div>
                    </div>
                </form>
              </div>
              <div class="tab-pane" id="pasillos">
                <form role="form" class="form-horizontal" action="" method="post">
                  <div class="box-body">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- jQuery 3.2.1 -->
    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </body>
</html>
