<?php 
if (!isset($_SESSION)) 
{
	session_start();
}
include_once('clases/class.CambiosMotivos.php');
include_once('clases/class.MySQL.php');

$cMotivos = new CambiosMotivos();
$db = new MySQL();

// recibimos los valores por POST via ajax
$nud = $_POST['idN'];
$fechaO = $_POST['fechaO'];
$idop = $_SESSION['idoperacion'];


$consultaCambios = "SELECT idCambiosMotivos,idProductoCambio,cantidad FROM CapturaCambios WHERE idoperacion = $idop 
AND nud = $nud AND FechaCambio = '$fechaO' AND estatusDis = 0";
$resultadoCambios = $db->consulta($consultaCambios);
$rowCambios = $db->fetch_assoc($resultadoCambios);

do {

		$idMotivos = $rowCambios['idCambiosMotivos'];
		$idProductos = $rowCambios['idProductoCambio'];
		$cantidad = $rowCambios['cantidad'];

		/*** Obtener la descripcion del motivo ***/
		$consulta = "SELECT Descripcion FROM CambiosMotivos WHERE idCambiosMotivos = $idMotivos LIMIT 1";
		$resultado = $db->consulta($consulta);
		$row = $db->fetch_assoc($resultado);


		/*** Obtener la descripcion del producto ***/
		$consulta2 = "SELECT pc.DescripcionInterna, pc.skuConver  FROM ProductosCambios pc WHERE  pc.idProductoCambio = $idProductos LIMIT 1";
		$resultado2 = $db->consulta($consulta2);
		$row2 = $db->fetch_assoc($resultado2);

		/*** Obtener la descripcion del producto de conversion***/
		$consulta4 = "SELECT pc.DescripcionInterna   FROM ProductosCambios pc WHERE pc.idoperacion = ".$idop." AND pc.sku= ".$row2['skuConver']." LIMIT 1";
		$resultado4 = $db->consulta($consulta4);
		$row4 = $db->fetch_assoc($resultado4);

		/** Obtengo el cliente**/
		$consulta3 = "SELECT nombre, O.iDdeposito  FROM Clientes C INNER JOIN Operaciones O ON C.iddeposito = O.iddeposito AND  C.nud = $nud AND O.idoperacion = $idop LIMIT 1";
		$resultado3 = $db->consulta($consulta3);
		$row3 = $db->fetch_assoc($resultado3);

		$cMotivos->setMotivos($idMotivos);
		$cMotivos->setDesMotivo($row['Descripcion']);
		$cMotivos->setProducto($idProductos);
		$cMotivos->setDesProducto($row2['DescripcionInterna']);
		$cMotivos->setCantidad($cantidad);
		$cMotivos->setNud($nud);
		$cMotivos->setDesCliente($row3['nombre']);
		$cMotivos->setFechaE($fechaO);
		$cMotivos->setProductoConv($row4['DescripcionInterna']);

		$cMotivos->addCambiosMotivos();
	
} while ($rowCambios = $db->fetch_assoc($resultadoCambios));

//Borramos la tabla con los cambios guardados anteriormente para guardar los nuevos

$consultaCambios = "DELETE FROM CapturaCambios WHERE idoperacion = $idop 
AND nud = $nud AND FechaCambio = '$fechaO' AND estatusDis = 0";
$db->consulta($consultaCambios);
$cMotivos->mostrarTabla();
?>