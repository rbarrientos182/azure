<?php 
 // establecer conexión
$mysqli = new mysqli('localhost','gepp','gepp','gepp');

//Comprueba la conexión 
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$consulta ="LOAD DATA LOCAL INFILE 'C:\\\wamp\\\www\\\gepp\\\pagina\\\sistema\\\clientes\\\Queretaro_17-02-14.txt' REPLACE INTO TABLE clientes FIELDS TERMINATED BY '\,'";

if(!$mysqli->query($consulta)){

	printf("Errormessage: %s\n", $mysqli->error);

}

/* Cierra la conexión */
$mysqli->close();

?>