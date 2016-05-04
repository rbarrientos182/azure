<?php
if (!isset($_SESSION)) 
{
	session_start();
}

ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time','1000');
ini_set('max_input_time','1000');

require_once('clases/class.MySQL.php');
require_once('clases/class.Indicadores.php');

/** obtengo la variable de sesion del deposito **/
$iddeposito = $_SESSION['idDeposito'];


$db = new MySQL();
$indicadores = new Indicadores();

$estatus = "";

if($_POST['action']=='upload'){
	
	/*** Recibo archivo y fecha ***/
	$total = count($_FILES['fileInput']['name']);

	
	//echo '<br>';
	/** Comprobamos que se haya enviado un archivo **/
	if($total>0)
	{
		for($i=0;$i<$total;$i++){

			//obtenemos los datos del archivo
			//echo '<br>';
			//echo 'tamano: ';
			$tamano = $_FILES['fileInput']['size'];
			//echo '<br>';
			//echo 'archivo:';
			$archivo = $_FILES['fileInput']['name'];
			//echo '<br>';
			$prefijo = substr(md5(uniqid(rand())),0,6);
			//echo 'archivo: ';
			$archivo = $iddeposito.'-'.$archivo;
			$destino = 'indicadores/'.$archivo;
		
			if($archivo!=""){
				//guardamos el archivo a la carpeta			
				if(move_uploaded_file($_FILES['fileInput']['tmp_name'], $destino)){
					$estatus = "Archivo subido <b>".$archivo."</b>";
					
					$estatus;
					/*** Llamamos a la clase indicadores ***/
					$indicadores->setArchivo($destino);
					$indicadores->setIdDeposito($iddeposito);
					$indicadores->leerArchivo();

				}
				else{
					echo $estatus = "Error al subir el archivo 1";
				}

			}
			else{
				echo $estatus = "Error al subir el archivo 2";
			}

			header('Location: sIndicadores.php?a=1&f='.$archivo);
		}
	}
	else{
		header('Location: sIndicadores.php');
	}
}
?>