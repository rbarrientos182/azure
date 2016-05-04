<?php
$no_visible_elements=true;
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
<?php include('footer.php'); ?>