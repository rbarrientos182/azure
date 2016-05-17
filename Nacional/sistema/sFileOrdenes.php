<div id="uploadFile">
	Subiendo Ordenes no cierre la ventana<img src="img/ajax-loaders/ajax-loader-7.gif" title="img/ajax-loaders/ajax-loader-7.gif">
</div>
<?php
if (!isset($_SESSION)) 
{
	session_start();
}

ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time','1000');
ini_set('max_input_time','1000');

require_once('clases/class.Orden.php');

/** obtengo la variable de sesion del deposito **/
$orden = new Orden();

$estatus = NULL;


if($_POST['action']=='upload'){
	
	/*** Recibo archivo y fecha ***/
	$total = count($_FILES['fileInput']['name']);
	
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
			//$prefijo = substr(md5(uniqid(rand())),0,6);
			//echo 'archivo: ';
			$archivo = $iddeposito.$archivo;
			$destino = 'ordenes/'.$archivo;
		
			if($archivo!=""){
				//guardamos el archivo a la carpeta			
				if(move_uploaded_file($_FILES['fileInput']['tmp_name'], $destino)){
					$estatus = "Archivo subido <b>".$archivo."</b>";
					
					/*** Llamamos a la clase orden ***/
					$orden->setArchivo($archivo);
					$resultado = $orden->leerArchivo();
					//echo 'salio';
				}
				else{
					echo $estatus = "Error al subir el archivo 1";
				}

			}
			else{
				echo $estatus = "Error al subir el archivo 2";
			}

			header('Location: sOrdenes.php?a=1,'.$archivo);

			
		}
	}
	else{
		header('Location: sOrdenes.php?a=0,'.$archivo);
	}
}
?>