<?php 
class ProductosCambios
{

	private $archivo = NULL;

	function __construct()
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

	}

	public function mostrarTabla($nombreSesion)
	{
		
		foreach ($_SESSION[$nombreSesion] as $sku) {
				
				echo $sku.'<br>';
			}	
	}

}
?>