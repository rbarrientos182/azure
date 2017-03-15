<div id="uploadFile">
	Subiendo Rutas no cierre la ventana<img src="img/ajax-loaders/ajax-loader-7.gif" title="img/ajax-loaders/ajax-loader-7.gif">
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


require_once('clases/class.Rutas.php');

/** obtengo la variable de sesion del deposito **/
$ruta = new Rutas();

$estatus = NULL;

if($_POST['action']=='upload'){

	/*** Recibo archivo y fecha ***/
	$total = count($_FILES['fileInput']['name']);

	/** Comprobamos que se haya enviado un archivo **/
	if($total>0)
	{
		for($i=0;$i<$total;$i++)
		{

			//obtenemos los datos del archivo
			//echo '<br>';
			//echo 'tamano: ';
			$tamano = $_FILES['fileInput']['size'];
			//echo '<br>';
			//echo 'archivo:';
			$archivo = $_FILES['fileInput']['name'];
			//echo '<br>';
			//echo 'archivo: ';
			//echo $archivo;
			$destino = 'rutas/'.$archivo;

			if($archivo!="")
			{
				//guardamos el archivo a la carpeta
				if(move_uploaded_file($_FILES['fileInput']['tmp_name'], $destino))
				{


					/*** Llamamos a la clase clientes ***/
					$ruta->setArchivo($archivo);
					$mensaje = $ruta->leerArchivo();
					$mensaje = "Archivo subido <b>".$archivo." y ".$mensaje."</b>";

				}
				else
				{
					 $mensaje = "Error al subir el archivo, no se pudo guardar el archivo";
				}

			}

			else
			{
				 $mensaje = "Error al subir el archivo, no existe el archivo";
			}

			header('Location: sRutas.php?a=1&f='.$mensaje);

		}
	}
	else
	{
		$mensaje = "No selecciono ningun archivo";
		header('Location: sRutas.php?a=0&f='.$mensaje);
	}
}
?>
