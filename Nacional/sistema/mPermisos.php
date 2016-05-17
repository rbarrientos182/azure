<?php
require_once('clases/class.MySQL.php');

$db = new MySQL();

$idUsuarios = $_POST['idUsuarios'];
$idoperacion = $_POST['operaciones'];



//borramos todos los permisos del usuario para volver a contruirlos
$consulta = "DELETE FROM Permisos WHERE idUsuarios = ".$idUsuarios;
$db->consulta($consulta);

//creamos un for para recorrer el array de idPermisos
for ($i=0; $i < count($idoperacion); $i++) { 
	$consulta2 = "INSERT INTO Permisos (idUsuarios,idoperacion)  VALUES (".$idUsuarios.",".$idoperacion[$i].")";
	$db->consulta($consulta2);
}

header('Location: fPermisosUsuario.php?id='.$idUsuarios);
?>