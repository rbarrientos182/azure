<?php
require_once('class.MySQL.php');
class Funciones extends MySQL
{
	public function eliminarDir($carpeta)
	{
		foreach(glob($carpeta . "/*") as $archivos_carpeta)
		{
			//echo $archivos_carpeta;
 
			if (is_dir($archivos_carpeta))
			{
				eliminarDir($archivos_carpeta);
			}
			else
			{
				unlink($archivos_carpeta);
			}
		}

		rmdir($carpeta);
	}

	public function eliminarRegistro($id,$tabla,$nombrepk){

		$consulta = "DELETE FROM $tabla WHERE $nombrepk = $id";
		$this->consulta($consulta);
	}

	public function GuardarGeneral($tabla,$campos,$valores,$tipo,$cuantos)
	{
		$arrayC = split(",", $campos);
		$arrayV = split(",", $valores);
		$arrayT = split(",", $tipos);

		$consulta = "INSERT INTO $tabla (";

		//construye el nombre de los campos de la tabla a insertar
		for($x=0;$x<$cuantos;$x++){

			$consulta .= $arrayC[$x].',';
		}

		$consulta = substr($consulta,0,-1);

		$consulta .= ") VALUES (";

		//construye la parte de Values

		for ($i=0;$i<$cuantos;$i++) {

			//si el valor es de tipo varchar se le agrega comillas simples a la concatenacion
			if($arrayT[$x]=='v'){
				$consulta .= "'".$arrayV['$x']."',";
			}
			//si no solamente se concatena el valor del array  
			else{
				$consulta .= $arrayV[$i].",";
			}
		}

		$consulta = substr($consulta,0,-1);

		$consulta .= ")";

		$this->consulta($consulta);

	}

	public function getDiasEnSemana($nSemana,$anio){

		date_default_timezone_set("America/Mexico_City");

		$week_number = $nSemana;
		$year = $anio;
		$diasSemana = array();

		for($day=0; $day<=6; $day++)
		{
			$fecha = date('Y-m-d', strtotime($year."W".str_pad($week_number,2,'0',STR_PAD_LEFT).$day));

			if($year==substr($fecha,0,4))
			{
					$diasSemana[] = $fecha;
    				//echo '<br>';
			}
    		
		}

		return $diasSemana;
	}


	public function getNoDiasEnSemana($nSemana,$anio){

		date_default_timezone_set("America/Mexico_City");

		$week_number = $nSemana;
		$year = $anio;
		$diasSemana = array();
		$dias = 0;

		for($day=0; $day<=6; $day++)
		{
			$fecha = date('Y-m-d', strtotime($year."W".str_pad($week_number,2,'0',STR_PAD_LEFT).$day));

			if($year==substr($fecha,0,4))
			{
					$dias++;
			}
    		
		}

		return $dias;
	}

	public function getMotivoClave($idmotivo){

		$arrayCvMotivos = array('31' => 'A','32'=>'B','34'=>'C','37'=>'D','80'=>'E','81'=>'F','82'=>'G','83'=>'H','84'=>'I','85'=>'J','86'=>'K');
		$cveMotivo = $arrayCvMotivos[$idmotivo];

		return $cveMotivo;
	}
}
?>