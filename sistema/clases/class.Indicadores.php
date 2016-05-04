<?php 
class Indicadores extends MySQL {

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
			$cadena = "INSERT INTO Indicador(idDeposito,mes,nSemana,dias,diaN,idRuta,visitasProgramadas,dosCajas,cajasSIO,cajasGepp,capacidadCamion,efectividadVisita,efectividadEntregaClientes,efectividadEntregaCajas) VALUES(";
			
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
            $cadena .= ");"; //Termina de armar la cadena para poder ser ejecutada
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
}
?>