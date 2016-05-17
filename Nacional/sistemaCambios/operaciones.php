<?php include('header.php'); 
$idoperacion = $_SESSION['idoperacion'];


$consulta = "SELECT p.SKU, p.descripcion FROM Productos p WHERE p.sku ORDER BY p.sku";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
<div>
	<ul class="breadcrumb">
		<li>
			<a href="index.php">Inicio</a> <span class="divider">/</span>
		</li>
		<li>
			<a href="operaciones.php">Catalogo Productos</a>
		</li>
	</ul>
</div>
			
<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-align-justify"></i>Catalogo Productos</h2>
			<div class="box-icon">	
				<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
			</div>
		</div>
	</div>
	<div class="box-content">
		<table class="table table-striped table-bordered bootstrap-datatable datatable">
			<thead>
				 <tr>
					<th>SKU</th>
					<th>Descripción</th>			  
				</tr>	
			</thead>  
			<tbody>
				<?php do{ 

					$consulta2 = "SELECT COUNT(sku) AS cuantos FROM ProductosCambios WHERE sku = ".$row['SKU']." AND idoperacion = $idoperacion AND estatus=1 LIMIT 1";
					$resultado2 = $db->consulta($consulta2);
					$row2 = $db->fetch_assoc($resultado2);
				?>
					<tr>
						<td><?php echo $row['SKU'];?></td>
						<td class="center">
							<?php echo $row['descripcion'];?>
							<div style="float:right;">
								<input id="sku<?php echo $row['SKU']?>" name="sku<?php echo $row['SKU']?>" type="checkbox" onclick="enviarProductosCambios('sku<?php echo $row["SKU"]?>')" value=<?php echo $row['SKU']?> <?php if($row2['cuantos']>0){ echo 'checked';}?>>
							</div>
						</td>
					</tr>
				<?php  }while($row = $db->fetch_assoc($resultado));?>
			</tbody>
		</table>            
	</div>
</div>
<div class="box-content" id="divProductosCambios" name="divProductosCambios">

</div>
<?php include('footer.php'); ?>