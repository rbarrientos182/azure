<?php include('header.php');

$idoperacion = $_SESSION['idoperacion'];

$consulta = "SELECT
	pc.idProductoCambio,
    pc.SKU AS sku,
    p.Descripcion AS Descripcion,
    pc.DescripcionInterna AS DescripcionInterna,
    pr.descripcion AS dempaque,
    IF(pc.estatus,'label-success','label-important') AS estatusP,
    IF(pc.estatus,'Habilitado','Inahabilitado') AS estatuss,
    CASE(pc.tmercado) WHEN 0 THEN 'Tradicional' WHEN 1 THEN 'Moderno' WHEN 2 THEN 'Híbrido' END AS TMercado
FROM
    productoscambios pc
        INNER JOIN
    productos p ON pc.sku = p.sku
        INNER JOIN
    productos pd ON pc.skuConver = pd.sku
		INNER JOIN
	presentacion pr ON pr.idpresentacion = p.idpresentacion
WHERE
    pc.idoperacion = $idoperacion ORDER BY pc.tmercado,pc.sku";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);
?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="catalogsP.php">Productos</a>
					</li>
				</ul>
			</div>

			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-align-justify"></i>Productos Cambios</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
						  	  <tr>
						  	  	<th colspan="5" style="text-align:left">Agregar Producto <a href="faProductos.php" class="icon icon-darkgray icon-add"></a></th>
						  	  </tr>
							  <tr>
								  <th>SKU</th>
								  <th>Producto</th>
								  <th>Descripción Interna</th>
								  <th>Empaque</th>
								  <th>Mercado</th>
								  <th>Estatus</th>
								  <th>Acciones</th>
							  </tr>
						  </thead>
						  <tbody>
						  	<?php do{

						  		?>
								<tr>
									<td class="center"><?php echo $row['sku']?></td>
									<td class="center"><?php echo $row['Descripcion'];?></td>
									<td class="center"><?php echo $row['DescripcionInterna'];?></td>
									<td class="center"><?php echo $row['dempaque'];?></td>
									<td class="center"><?php echo $row['TMercado'];?></td>
									<td class="center">
										<span class="label <?php echo $row['estatusP']; ?>"><?php echo $row['estatuss'];?></span>
									</td>
									<td class="center">
										<a class="btn btn-info" href="fmProductos.php?id=<?php echo $row['idProductoCambio'];?>&id2=<?php echo $row['sku'];?>">
											<i class="icon-edit icon-white"></i>
											Editar
										</a>
									</td>
								</tr>
							<?php }while($row = $db->fetch_assoc($resultado)); ?>
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->

			</div><!--/row-->
<?php include('footer.php'); ?>
