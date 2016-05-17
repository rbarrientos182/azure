<?php 
require_once('class.MySQL.php');

class Tiempos extends MySQL {

	private $archivo = NULL;
	private $idDeposito = NULL;

	public function setArchivo ($archivo){
		$this->archivo = $archivo;
		
	}

	public function setIdDeposito ($idDeposito){
		$this->idDeposito = $idDeposito;
		
	}

	public function leerArchivo (){

		//echo 'entro a leeerAchivo';
		$row = 1;
		$fp = fopen($this->archivo,"r");
		$contador = 1;
		while (($data = fgetcsv($fp,1000,',')) !== FALSE )//Mientras hay líneas que leer...
		{ 

			$total = count($data);
			//echo 'El total es: '.$total.'<br>';
			$contador++;
			$cadena = "INSERT INTO Tiempos (idDeposito,mes,nSemana,dia,fecha,linea,inicioOptimo,tiempoExcedido,colaEspera,disenio,totalTiempo,fin,inicio,observaciones,tipo) VALUES(";
			
			$cadena .= $this->idDeposito.",";	

			for($x=0; $x<$total; $x++)
			{ //Aquí va colocando los campos en la cadena, si aun no es el último campo, le agrega la coma (,) para separar los datos
        		if ($x==($total-1)){
              		$cadena .= "'".$data[$x]."'";
              		//echo '<br>';
              	}
        		else{
              		$cadena .= "'".$data[$x]."',";
              		//echo '<br>';
              	}
            }
            $cadena .= ",1);"; //Termina de armar la cadena para poder ser ejecutada
			//echo '<br>';
			//echo $cadena;
			//echo '<br>';
    		//echo $cadena."<br>";  //Muestra la cadena para ejecutarse
		    $this->consulta($cadena);		
    		
    	}
	
			/*foreach ($data as $row)
			{
				echo "Campo $i: $row<br>\n"; //Muestra todos los campos de la fila actual
				if($i>=4){ // contar cuantos campos son los que se van a guardar en la BD para hacer empezar con la siguiente tupla
					echo '<br>';
					$i=-1;
				}
				$i++;	
			}
			echo "<br/><br/>\n\n";*/
		fclose ($fp); 
	}

	public function obtenerInicioOptimo($inicio){

		$hora1 = $inicio;
		$hora2 = "20:00";

		//si la hora1 (hora inicio) es menor a las 20:00 horas el inicio optimo es igual a la hora1
		if($hora1 < $hora2){

			$inicioOptimo = $hora1;
		}

		//en caso contrario el inicio optimo es igual a la hora2 (20:00)
		else{

			$inicioOptimo = $hora2;
		}

		return $inicioOptimo;

	}


	public function obtenerDiferenciaHoras($horaInicio,$horaTermino){

		$h1 = substr($horaInicio,0,-3);
		$m1 = substr($horaInicio,3,2);
		$h2 = substr($horaTermino,0,-3);
		$m2 = substr($horaTermino,3,2);
		$ini = (($h1*60)*60)+($m1*60);
		$fin = (($h2*60)*60)+($m2*60);
		$dif = $fin-$ini;
		$difh = floor($dif/3600);
		$difm = floor(($dif-($difh*3600))/60);
		//echo $difs = floor(($difh - $difm) /60)-1;
		//echo '<br>';

		return date("H:i",mktime($difh,$difm));
	}


	public function obtenerTiempoTotal($horaInicio,$horaDisenio,$horaEspera){

		$h1 = substr($horaInicio,0,-3);
		$m1 = substr($horaInicio,3,2);
		$h2 = substr($horaDisenio,0,-3);
		$m2 = substr($horaDisenio,3,2);
		$h3 = substr($horaEspera,0,-3);
		$m3 = substr($horaEspera,3,2);
		

		$ini = (($h1*60)*60)+($m1*60);
		$dis = (($h2*60)*60)+($m2*60);
		$esp = (($h3*60)*60)+($m3*60);

		
		$total = $ini+$dis+$esp;
		

		$totalh = floor($total/3600);
		$totalm = floor(($total-($totalh*3600))/60);
		//echo $difs = floor(($difh - $difm) /60)-1;
		//echo '<br>';

		return date("H:i",mktime($totalh,$totalm));

	}

}
?>