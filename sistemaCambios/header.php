<?php
if (!isset($_SESSION))
{
	session_start();
}

if(!isset($_SESSION['NumEmpleado'])&&!isset($_SESSION['idoperacion']))
{
	header('Location: login.php');
}

require_once('clases/class.MySQL.php');

$db = new MySQL();

date_default_timezone_set('America/Mexico_City');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Distribución Pepsi</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Distribución Pepsi">
	<meta name="author" content="Roberto Barrientos">

	<!-- The styles -->
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link href='css/validationEngine.jquery.css' rel='stylesheet'>
	<link href='css/magnific-popup.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="img/logo.ico">

</head>

<body>
	<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
	<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.php"> <img alt="Logo GEPP" src="img/Pepsi-logo.png" /></a>

				<!-- theme selector starts -->
				<div class="btn-group pull-right theme-container" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-tint"></i><span class="hidden-phone"> Cambiar Tema / Template</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" id="themes">
						<li><a data-value="classic" href="#"><i class="icon-blank"></i> Classic</a></li>
						<li><a data-value="cerulean" href="#"><i class="icon-blank"></i> Cerulean</a></li>
						<li><a data-value="cyborg" href="#"><i class="icon-blank"></i> Cyborg</a></li>
						<li><a data-value="redy" href="#"><i class="icon-blank"></i> Redy</a></li>
						<li><a data-value="journal" href="#"><i class="icon-blank"></i> Journal</a></li>
						<li><a data-value="simplex" href="#"><i class="icon-blank"></i> Simplex</a></li>
						<li><a data-value="slate" href="#"><i class="icon-blank"></i> Slate</a></li>
						<li><a data-value="spacelab" href="#"><i class="icon-blank"></i> Spacelab</a></li>
						<li><a data-value="united" href="#"><i class="icon-blank"></i> United</a></li>
					</ul>
				</div>
				<!-- theme selector ends -->

				<!-- user dropdown starts -->
				<?php
	                $NumEmpleado = $_SESSION['NumEmpleado'];
	                $nivel = $_SESSION['nivel'];
	                $idoperacion = $_SESSION['idoperacion'];
					$consulta = "SELECT
    NumEmpleado,
    Nombre,
    IF(PPP=0,'',PPP) AS PPP,
    nivel AS niv,
    CASE nivel
        WHEN 1 THEN 'Supervisor'
        WHEN 2 THEN 'Promotor'
        WHEN 3 THEN 'Consulta'
        WHEN 4 THEN 'Administrador'
    END AS nivel,
    d.idDeposito,
    deposito,
    region
FROM
    UsrCambios usr
        INNER JOIN
    Operaciones o ON usr.idoperacion = O.idoperacion
        INNER JOIN
    Deposito d ON o.idDeposito = d.idDeposito
        INNER JOIN
    zona z ON d.idzona = z.idzona
        INNER JOIN
    region r ON z.idRegion = r.idRegion
WHERE
    NumEmpleado = $NumEmpleado
        AND o.idoperacion = $idoperacion";

					$resultado = $db->consulta($consulta);
					$row = $db->fetch_assoc($resultado);
				?>
					<?php echo $row['region']," - ".$row['idDeposito']." - ".$row['deposito']?><br><br>
					<?php echo $row['nivel']." - ".$row['PPP']." - ".$NumEmpleado." - ".$row['Nombre']; ?>


						<!--<p><b>All pages in the menu are functional, take a look at all, please share this with your followers.</b></p>-->
				<div class="clearfix"></div>

				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					 	<i class="icon-user"></i><span class="hidden-phone"> Usuario</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<!--<li><a href="#">Perfil</a></li>-->
						<li class="divider"></li>
						<li><a href="logout.php">Salir</a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->

				<div class="top-nav nav-collapse">
					<ul class="nav">
						<li><a href="#">Visita el Sitio</a></li>
						<li>
							<form class="navbar-search pull-left">
								<input placeholder="Buscar" class="search-query span2" name="query" type="text">
							</form>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<!-- topbar ends -->
	<?php } ?>
	<div class="container-fluid">
		<div class="row-fluid">
		<?php if(!isset($no_visible_elements) || !$no_visible_elements) { ?>

			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header hidden-tablet">Menú</li>
						<li><a class="ajax-link" href="index.php"><i class="icon-home"></i><span class="hidden-tablet"> Inicio</span></a></li>
						<?php if($NumEmpleado=='999999'){ ?>
							<li class="nav-header hidden-tablet">Alta Depósito</li>
							<li><a class="ajax-link" href="sProductos.php"><i class="icon-file"></i><span class="hidden-tablet">Importar Productos</span></a></li>
							<li><a class="ajax-link" href="sSupervisores.php"><i class="icon-file"></i><span class="hidden-tablet">Importar Grupos Supervisores</span></a></li>
							<li><a class="ajax-link" href="sUsuarios.php"><i class="icon-file"></i><span class="hidden-tablet">Importar Usuarios</span></a></li>
							<li><a class="ajax-link" href="sRutas.php"><i class="icon-file"></i><span class="hidden-tablet">Importar Rutas</span></a></li>
						<?php }?>
						<li class="nav-header hidden-tablet">Cambios</li>
						<?php if($nivel==1 || $nivel==4){?>
							<li><a class="ajax-link" href="usuarios.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Usuarios</span></a></li>
						<?php }?>
							<li><a class="ajax-link" href="fmContrasena.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Cambio Contraseña</span></a></li>
						<?php if($nivel==4){?>
							<li><a class="ajax-link" href="rutas.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Rutas</span></a></li>
							<!--<li><a class="ajax-link" href="Motivos.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Catalogo Motivos</span></a></li>-->
							<li><a class="" href="catalogsP.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Productos Cambios</span></a></li>
							<li><a class="" href="GSupervision.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Grupos de Supervision</span></a></li>

							<li><a class=""href="sClientes.php"><i class="icon-file"></i><span class="hidden-tablet">Subir Clientes</span></a></li>
						<?php }?>
						<?php if(/*$nivel==1 || */$nivel==2/*|| $nivel==4*/){?>
							<li><a class="" href="AltaCambios.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Captura de Cambios</span></a></li>
						<?php }?>
						<?php if($nivel==2){?>
							<li><a class="" href="consultaReportesPromotores.php"><i class="icon-print"></i><span class="hidden-tablet">Reporte</span></a></li>
						<?php }?>
						<?php if($nivel==1 || $nivel==4 || $nivel==3){?>
							<li><a class="" href="consultaReportes.php"><i class="icon-print"></i><span class="hidden-tablet">Reportes</span></a></li>
							<!--<li><a class="" href="consultaReportesIndicadores.php"><i class="icon-print"></i><span class="hidden-tablet">Reportes Indicadores</span></a></li>-->
					        <!--<li><a class="" href="grafica.php"><i class="icon-signal"></i><span class="hidden-tablet">Graficas</span></a></li>-->
						<?php } ?>
						<?php //if($nivel==1 || $nivel==4){?>
							<!--<li><a class="" href="cierreDia.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Cierre de Día</span></a></li>-->
						<?php //} ?>
						<!--<li><a class="" href="catalogsM.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Catalogo Motivos</span></a></li>-->
						<!-- <li><a class="" href="operaciones.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Catalogo Productos</span></a></li> -->
						<!--<li><a class="ajax-link" href="operaciones_deposito.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Operaciones Deposito</span></a></li>
						<li><a class="" href="regiones.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Regiones</span></a></li>
						<li><a class="" href="zonas.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Zonas</span></a></li>
						<li><a class="" href="depositos.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Depositos</span></a></li>
						<li><a class="ajax-link" href="unidades.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Unidades</span></a></li>
						<li><a class="ajax-link" href="rutas.php"><i class="icon-align-justify"></i><span class="hidden-tablet"> Rutas</span></a></li>
						<li><a href="filtroClientes.php"><i class="icon-align-justify"></i><span class="hidden-tablet"> Clientes</span></a></li>
						<li><a class="ajax-link" href="productos.php"><i class="icon-align-justify"></i><span class="hidden-tablet"> Productos</span></a></li>
						<li><a href="sOrdenes.php"><i class="icon-file"></i><span class="hidden-tablet">Subir Ordenes</span></a></li>-->

						<!--<li><a href="sProductos.php"><i class="icon-file"></i><span class="hidden-tablet">Subir Productos</span></a></li>-->
						<!--<li><a class="ajax-link" href="sIndicadores.php"><i class="icon-file"></i><span class="hidden-tablet">Subir Indicadores</span></a></li>
						<li><a class="ajax-link" href="sTiemposO.php"><i class="icon-file"></i><span class="hidden-tablet">Subir Tiempos de Operación</span></a></li>-->
						<!--<li class="nav-header hidden-tablet">Indicadores</li>
						<li><a  href="aTiempos.php"><i class="icon-list-alt"></i><span class="hidden-tablet">Concentro Tiempos</span></a></li>
						<li><a  href="dNumerico.php"><i class="icon-list-alt"></i><span class="hidden-tablet">Detallado Númerico</span></a></li>
						<li><a  href="estadisticas.php"><i class="icon-list-alt"></i><span class="hidden-tablet">Detallado Gráfico</span></a></li>
						<li><a  href="dGrafico.php"><i class="icon-list-alt"></i><span class="hidden-tablet">Detallado Tiempos</span></a></li>
						<li><a  href="dEnvioR.php"><i class="icon-list-alt"></i><span class="hidden-tablet">Envío y Recepción de Datos</span></a></li>
						<li class="nav-header hidden-tablet">Cambios de Producto</li>-->
						<!--<li class="nav-header hidden-tablet">Examples</li>
						<li><a class="ajax-link" href="ui.php"><i class="icon-eye-open"></i><span class="hidden-tablet"> UI Features</span></a></li>
						<li><a class="ajax-link" href="form.php"><i class="icon-edit"></i><span class="hidden-tablet"> Forms</span></a></li>
						<li><a class="ajax-link" href="chart.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Charts</span></a></li>
						<li><a class="ajax-link" href="typography.php"><i class="icon-font"></i><span class="hidden-tablet"> Typography</span></a></li>
						<li><a class="ajax-link" href="gallery.php"><i class="icon-picture"></i><span class="hidden-tablet"> Gallery</span></a></li>
						<li class="nav-header hidden-tablet">Sample Section</li>
						<li><a class="ajax-link" href="table.php"><i class="icon-align-justify"></i><span class="hidden-tablet"> Tables</span></a></li>
						<li><a class="ajax-link" href="calendar.php"><i class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span></a></li>
						<li><a class="ajax-link" href="grid.php"><i class="icon-th"></i><span class="hidden-tablet"> Grid</span></a></li>
						<li><a class="ajax-link" href="file-manager.php"><i class="icon-folder-open"></i><span class="hidden-tablet"> File Manager</span></a></li>
						<li><a href="tour.php"><i class="icon-globe"></i><span class="hidden-tablet"> Tour</span></a></li>
						<li><a class="ajax-link" href="icon.php"><i class="icon-star"></i><span class="hidden-tablet"> Icons</span></a></li>
						<li><a href="error.php"><i class="icon-ban-circle"></i><span class="hidden-tablet"> Error Page</span></a></li>
						<li><a href="login.php"><i class="icon-lock"></i><span class="hidden-tablet"> Login Page</span></a></li>-->
					</ul>
					<label id="for-is-ajax" class="hidden-tablet" for="is-ajax"><input id="is-ajax" type="checkbox"> Ajax en menú</label>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends -->

			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>

			<div id="content" class="span10">
			<!-- content starts -->
			<?php } ?>
