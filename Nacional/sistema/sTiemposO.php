<?php 
require_once('header.php');

if(isset($_GET['a'])){
	$files = $_GET['f'];
?>
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<i class="icon-info-sign"></i> Archivos: <?php echo substr($files,0,-2); ?> subidos con éxito.
	</div>
<?php 
}
?>
<div>
	<ul class="breadcrumb">
		<li>
			<a href="index.php">Inicio</a> <span class="divider">/</span>
		</li>
		<li>
			<a href="sTiemposO.php">Subir Tiempos de Operación</a>
		</li>
	</ul>
</div>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-upload"></i>Subir Tiempos de Operación</h2>
			<div class="box-icon">
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
            <form class="form-horizontal" enctype="multipart/form-data" action="sFileTiemposO.php" method="post">
            	<fieldset>
					<div class="control-group"> 		
						<label class="control-label" for="fileInput">Archivo</label>
						<div class="controls">
							<input id="action" name="action" value="upload" type="hidden">
							<input id="fileInput" name="fileInput" type="file">
							<div id="listMultiple" style="border:#999 solid 3px; padding:10px">
								"Archivo:"
							</div>
							<div id="uploadFile" style=" display:none">
								<img src="img/ajax-loaders/ajax-loader-7.gif" title="img/ajax-loaders/ajax-loader-7.gif">
							</div>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" id="btn_subirPDF" class="btn btn-primary">Subir Archivo</button>
						<button type="reset" class="btn">Cancelar</button>
					</div>      
            	</fieldset>
            </form>
        </div>
	</div><!--/span-->
    <!--<iframe class="control-label" width="60%" height="70px" id="a_subir" name="a_subir">-->
       	<!--Aquí va el código PHP-->
        <!--aca va el codigo-->
    <!--</iframe>-->     
</div><!--/row-->
<?php include('footer.php'); ?>