<?php
date_default_timezone_set('America/Mexico_City');

class Utilidades
{  
     	 
	 //funcion de coneccion con la base de datos
	public function __construct()
	{  
	 	
	}  
	
	//funcion de consulta con la base. parametro el query
	public function obtenerHemisferio()
	{  
		/** comprueba la fecha y obtiene que numero de dia es **/
		$fecha = date('Y-m-j');
		$nuevafecha = strtotime($fecha);
		$nuevafecha = date ('Y-m-j', $nuevafecha );
		$diaSemana =  date('w',$fecha);

		if($diaSemana==2 || $diaSemana==4 || $diaSemana==6){

		  $hemisferio = 1;

		}

		elseif($diaSemana==3 || $diaSemana==5 || $diaSemana==7) {
		  $hemisferio = 2;

		}

		return $hemisferio;
		
	}

	public function obtenerIntervalo()
	{  
		/** comprueba la fecha y obtiene que numero de dia es **/
		$diaSemana = date('w');

		if($diaSemana==1){

		  $interval = 2;

		}

		else{

		  $interval = 1;

		}
		return $interval;
		
	}

	public function validarHora()
	{
		$valor = false;
		if(date("H:i:s") > 13){
			$valor = true;
		}

		return $valor;

	}

}
?>