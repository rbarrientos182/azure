<?php
include_once '../../class/class.MySQL.php';
$db = new MySQL();

$ideposito = $_GET['deposito'];

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reportePasillo.xls");
header("Pragma: no-cache");
header("Expires: 0");

/** Query para obtener el idDeposito**/
$query = "SELECT
    deposito, idpasillo, p.idpaquete sku, pr.descripcion
FROM
    pasillos p
        INNER JOIN
    deposito de ON de.idDeposito = p.iddeposito
        INNER JOIN
    productos pr ON pr.sku = p.idpaquete
WHERE
    p.iddeposito = $ideposito
ORDER BY idpasillo , sku";
$result = $db->consulta($query);
$row = $db->fetch_assoc($result);
?>
<!DOCTYPE html>
	<html>
	<head>
	<meta charset="UTF-8">
	<title>Reporte Bodega</title>
	</head>
	<body>
	<table width="750" height="112" border="0">
    <thead>
      <tr>
       <th>Pasillo</th>
       <th>SKU</th>
       <th>Descripción</th>
      </tr>
    </thead>
	  <tbody>
	    <?php
        do{
      ?>
      <tr>
        <td><?php echo $row['idpasillo'];?></td>
        <td><?php echo $row['sku'];?></td>
        <td><?php echo $row['descripcion'];?></td>
      </tr>
      <?php
        }while($row = $db->fetch_assoc($result));
      ?>
	  </tbody>
	</table>
	</body>
	</html>
