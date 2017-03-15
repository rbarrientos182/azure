<?php
require_once("clases/class.MySQL.php");

$db = new MySQL();

$consulta = "SELECT
    idoperacion,
    NumEmpleado,
    Nombre,
    Psw,
    PPP,
    nivel,
    asignado,
    MD5(NumEmpleado) AS nuevopsw
FROM
    usrcambios
WHERE
    nivel != 4
ORDER BY idoperacion";
$resultado = $db->consulta($consulta);
$row = $db->fetch_assoc($resultado);

do {
echo $consulta2 = "UPDATE usrcambios
SET
    Psw = '".$row['nuevopsw']."'
WHERE
    idoperacion = ".$row['idoperacion']." AND NumEmpleado = ".$row['NumEmpleado'].";";
echo '<br>';
} while ($row = $db->fetch_assoc($resultado));
?>
