<?php
include_once 'class/class.MySQL.php';
$db = new MySQL();
$query = "SELECT * FROM Deposito ORDER BY deposito";
$result = $db->consulta($query);
$row = $db->fetch_assoc($result);

$query2 = "SELECT * FROM Deposito ORDER BY deposito";
$result2 = $db->consulta($query2);
$row2 = $db->fetch_assoc($result2);

$query3 = "SELECT * FROM Deposito ORDER BY deposito";
$result3 = $db->consulta($query3);
$row3 = $db->fetch_assoc($result3);

$query4 = "SELECT * FROM Deposito ORDER BY deposito";
$result4 = $db->consulta($query4);
$row4 = $db->fetch_assoc($result4);
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
    <link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.structure.min.css" rel="stylesheet"type="text/css" >
    <!--<link href="css/jquery-ui.theme.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/redmond/jquery-ui.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">
    <link href="css/css/validationEngine.jquery.css" rel="stylesheet"  type="text/css">
    <link href="css/styles.css" rel="stylesheet"  type="text/css">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <h1>Configuración PCT</h1>
        <div class="col-md-10">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#paletizador" data-toggle="tab">Parámetros Generales</a></li>
              <li><a href="#pasillos" data-toggle="tab">Pasillos</a></li>
              <li><a href="#armados" data-toggle="tab">Armados</a></li>
              <li><a href="#ajuste" data-toggle="tab">Ajuste Manual PCT</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="paletizador">
                <form role="form" class="form-horizontal" action="scripts/guardarPaletizador.php" method="post" id="formPaletizador">
                    <div class="box-body">
                      <div class="form-group">
                          <label class="col-sm-2 control-label" for="exampleInputEmail1">CEDIS</label>
                          <div class="col-sm-8">
                            <select class="form-control" id="cedis" name="cedis">
                                <option>Seleccione un CEDIS</option>
                                <?php do{?>
                                  <option value="<?php echo $row['idDeposito']; ?>"><?php echo utf8_encode($row['deposito']); ?></option>
                                <?php }while($row = $db->fetch_assoc($result));?>
                            </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Largo de Tarima</label>
                        <input type="hidden" id="accion" name="accion">
                        <input type="hidden" id="idpaletizador" name="idpaletizador">
                        <div class="col-sm-8">
                          <input type="text" id="largotarima" class="form-control" style="width:100px" name="largotarima" value="" data-validation-engine="validate[required,custom[integer]]">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Ancho de Tarima</label>
                        <div class="col-sm-8">
                          <input type="text" id="anchotarima" class="form-control" style="width:100px" name="anchotarima" value=""  data-validation-engine="validate[required,custom[integer]]">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Margen Interior</label>
                        <div class="col-sm-8">
                          <input type="text" id="margen" class="form-control" style="width:100px" name="margen" value="" data-validation-engine="validate[required,custom[integer]]">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Margen Exterior</label>
                        <div class="col-sm-8">
                          <input type="text" id="margen1" class="form-control" style="width:100px" name="margen1" value="" data-validation-engine="validate[required,custom[integer]]">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Tipo Tarima A</label>
                        <div class="col-sm-8">
                          <input type="text" id="tarima1" class="form-control" style="width:100px" name="tarima1" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Tipo Tarima B</label>
                        <div class="col-sm-8">
                          <input type="text" id="tarima2" class="form-control" style="width:100px" name="tarima2" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Tipo Tarima C</label>
                        <div class="col-sm-8">
                          <input type="text" id="tarima3" class="form-control" style="width:100px" name="tarima3" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Tipo Tarima D</label>
                        <div class="col-sm-8">
                          <input type="text" id="tarima4" class="form-control" style="width:100px" name="tarima4" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Tipo Tarima E</label>
                        <div class="col-sm-8">
                          <input type="text" id="tarima5" class="form-control" style="width:100px" name="tarima5" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">% Min Tipo A</label>
                        <div class="col-sm-8">
                          <input type="text" id="pcompleta" class="form-control" style="width:100px" name="pcompleta" value="" data-validation-engine="validate[custom[number]]">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">%Min Tipo B</label>
                        <div class="col-sm-8">
                          <input type="text" id="pbandera" class="form-control" style="width:100px" name="pbandera" value="" data-validation-engine="validate[custom[number]]">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">% Min Tipo C</label>
                        <div class="col-sm-8">
                          <input type="text" id="pescuadra" class="form-control" style="width:100px" name="pescuadra" value="" data-validation-engine="validate[custom[number]]">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">% Min Tipo D</label>
                        <div class="col-sm-8">
                          <input type="text" id="pcombinada" class="form-control" style="width:100px" name="pcombinada" value="" data-validation-engine="validate[custom[number]]">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">SKU Garrafón</label>
                        <div class="col-sm-8">
                          <input type="text" id="skug" class="form-control" style="width:100px" name="skug" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="exampleInputEmail1">Cálculo por Pasillos</label>
                        <div class="col-sm-8">
                          <input type="text" id="cpasillos" class="form-control" style="width:100px" name="cpasillos" value="" data-validation-engine="validate[required,custom[integer]]">
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
              </div><!-- paletizador-->
              <div class="tab-pane" id="pasillos">
                <form role="form" class="form-horizontal" method="post">
                  <div class="box-body">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-12">
                          <label class="col-sm-2 control-label" for="exampleInputEmail2">CEDIS</label>
                          <div class="col-sm-8">
                            <select class="form-control" id="nocedis" name="nocedis">
                              <option value="0">Seleccione un CEDIS</option>
                              <?php do{?>
                                <option value="<?php echo $row2['idDeposito']; ?>"><?php echo utf8_encode($row2['deposito']);?></option>
                              <?php }while($row2 = $db->fetch_assoc($result2));?>
                            </select><!-- fin de select -->
                          </div><!-- col-sm-8 -->
                        </div><!-- col-md-12 -->
                      </div><!-- row -->
                    </div><!-- form-group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-12">
                          <label class="col-sm-2 control-label" for="exampleInputEmail1">Pasillo</label>
                          <div class="col-sm-8">
                            <select class="form-control" id="pasillo" name="pasillo">
                              <option value="0">Seleccione un Pasillo</option>
                            </select>
                          </div><!-- col-sm-8 -->
                          <div class="col-sm-2">
                            <button type="button" id="btnNuevo" class="btn btn-default">Nuevo</button>
                          </div><!-- col-sm2-->
                        </div><!--col-md-12 -->
                      </div><!-- row-->
                    </div><!-- form-group-->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-5">
                          <label class="col-sm-2 control-label" for="exampleInputEmail1">Disp.</label>
                          <div class="col-sm-8">
                            <select class="form-control" id="productos" name="productos" size="20" multiple="multiple">
                              <option>Seleccione Productos</option>
                            </select>
                          </div><!-- col-sm-8 -->
                        </div><!-- col-md-5 -->
                        <div class="col-md-2">
                          <div class="bs-glyphicons">
                            <ul class="bs-glyphicons-list">
                              <br><br>
                              <button type="button" class="btn btn-default" id="del"><==</button>
                              <br><br>
                              <button type="button" class="btn btn-default" id="add">==></button>
                              <br><br>
                              <button type="button" class="btn btn-default" id="exportxls">Exportar a excel</button>
                            </ul>
                          </div><!--bs-glyphicons-->
                        </div><!--col-md-2-->
                        <div class="col-md-5">
                          <label class="col-sm-2 control-label" for="exampleInputEmail1">Armados</label>
                          <div class="col-sm-8">
                            <select class="form-control" id="sku" name="sku" size="20" multiple="multiple">
                              <option>Seleccione un Producto Armado</option>
                            </select>
                          </div><!--col-sm-8-->
                        </div><!--col-md-5-->
                      </div><!-- row-->
                    </div><!--form-group -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                          <button type="button" class="btn btn-default" id="btnGuardar">Guardar</button>
                          <button type="reset" class="btn btn-default" id="btnCancelar">Cancelar</button>
                        </div><!--col-sm-offset-2 col-sm-6-->
                    </div><!--form-group-->
                  </div><!-- fin de box-body-->
                </form><!-- fin de form -->
              </div><!-- pasillos-->
              <div class="tab-pane" id="armados">
               <form role="form" class="form-horizontal" method="post">
                <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="exampleInputEmail1">CEDIS</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="deposito" name="deposito">
                        <option value="0">Seleccione un CEDIS</option>
                        <?php do{?>
                          <option value="<?php echo $row3['idDeposito']; ?>"><?php echo utf8_encode($row3['deposito']); ?></option>
                        <?php }while($row3 = $db->fetch_assoc($result3));?>
                      </select>
                    </div><!--col-sm-8-->
                  </div><!--form-group-->
                   <div class="form-group">
                    <label class="col-sm-2 control-label" for="exampleInputEmail1">Fecha</label>
                    <div class="col-sm-8">
                      <input type="text" id="datepicker" class="form-control" style="width:100px" name="datepicker" value="<?php echo date('Y-m-d');?>" readonly>
                    </div><!--col-sm-8-->
                  </div><!--form-group-->
                  <div class="form-group">
                    <div class="col-sm-8">
                      <button type="button"  class="btn btn-default" id="btnFind" name="btnFind">Buscar</button>
                    </div><!--col-sm-8-->
                  </div><!--form-group-->
                  <div class="form-group">
                    <div class="table-responsive">
                      <table id="tablaConsulta" class="table table-striped table-hover table-condensed">
                        <thead class="thead-inverse">
                          <tr>
                            <th>No. Cedis</th>
                            <th>Fecha</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estatus</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div><!--form-group-->
                </div><!--box-body-->
               </form>
              </div><!-- armados -->
              <div class="tab-pane" id="ajuste">
               <form role="form" class="form-horizontal" method="post">
                <div class="box-body">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="exampleInputEmail1">CEDIS</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="depositoconf" name="depositoconf">
                        <option value="0">Seleccione un CEDIS</option>
                        <?php do{?>
                          <option value="<?php echo $row4['idDeposito']; ?>"><?php echo utf8_encode($row4['deposito']); ?></option>
                        <?php }while($row4 = $db->fetch_assoc($result4));?>
                      </select>
                    </div><!--col-sm-8-->
                  </div><!--form-group-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="exampleInputEmail1">Fecha</label>
                    <div class="col-sm-8">
                      <input type="text" id="datepicker2" class="form-control" style="width:100px" name="datepicker2" value="<?php echo date('Y-m-d');?>" readonly>
                    </div><!--col-sm-8-->
                  </div><!--form-group-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="exampleInputEmail1">Ruta</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="rutaconf" name="rutaconf">
                        <option value="0">Seleccione una Ruta</option>
                      </select>
                    </div><!--col-sm-8-->
                  </div><!--form-group-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="exampleInputEmail1">Tarima</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="tarimaconf" name="tarimaconf">
                        <option value="0">Seleccione una Tarima</option>
                      </select>
                      <input type="hidden" id="ultimatarima" name="ultimatarima">
                    </div><!--col-sm-8-->
                  </div><!--form-group-->
                  <!--<div class="form-group">
                    <div class="col-sm-8">
                      <button type="button"  class="btn btn-default" id="btnFindconf" name="btnFindconf">Buscar</button>
                    </div>--><!--col-sm-8-->
                  <!--</div>--><!--form-group-->
                  <div class="form-group">
                    <div class="table-responsive">
                      <table id="tablaCTarimas" class="table table-striped table-hover table-condensed">
                        <thead class="thead-inverse">
                          <tr>
                            <th>SKU</th>
                            <th>Producto</th>
                            <th>Cajas</th>
                            <th>Mover Numero de Tarima</th>
                            <th>Cajas Asignar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div><!--form-group-->
                  <div class="form-group">
                    <div class="col-sm-8">
                      <button type="button"  class="btn btn-default" id="btnSaveConf" name="btnSaveConf">Guardar</button>
                    </div><!--col-sm-8-->
                  </div><!--form-group-->
                  <div class="form-group">
                </div><!--box-body-->
               </form>
              </div><!-- ajuste manual -->
            </div><!-- fin tab-content-->
          </div>
        </div>
      </div>
    </div>
    <!-- jQuery 3.2.1 -->
    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="js/jquery.numeric.min.js" type="text/javascript"></script>
    <script src="js/datepicker-es.js" type="text/javascript"></script>
    <!-- Validation Engine -->
    <script src="js/jquery.validationEngine-es.js" type="text/javascript"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/bootstrap-notify.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/functions.js" type="text/javascript" charset="utf-8"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php
      if(isset($_GET['var1'])){
        $var1 = $_GET['var1'];
        echo "<script 'type=text/javascript'>";
        echo "showMessageSuccess('La acción se ha realizado con éxito');";
        echo "</script>";
      }
    ?>
  </body>
</html>
