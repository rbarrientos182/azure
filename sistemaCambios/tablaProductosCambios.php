<?php
if (!isset($_SESSION)) 
{
	session_start();
}

require_once('clases/class.ProductosCambios.php');

$pCambios = new ProductosCambios();
 
$productos = $_POST['productos'];
$productosDescripcion = $_POST['productosDescripcion'];

$productos = substr($productos, 3);
//echo '<br>';
$productosDescripcion = substr($productosDescripcion, 1);


$productos = split(",",$productos);
$productosDescripcion = split(",",$productosDescripcion);

$x = 0;

foreach ($productos as $sku)
{
		$pCambios->setItem($sku);
		$pCambios->setDescripcion($productosDescripcion[$x]);
		$pCambios->addProducto();


        $x++;
        //echo '<br>';
}

$pCambios->mostrarTabla();
?>
