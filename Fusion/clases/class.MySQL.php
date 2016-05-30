<?php
class MySQL
{  
   

     	 
	 //funcion de coneccion con la base de datos
	public function __construct()
	{  
	 	if(!isset($this->conexion))
		{  

		$this->conexion = mysqli_connect($this->host,$this->user,$this->pass,$this->db) or die("Error ".mysqli_error($this->conexion));

		}  
		
	}  
	
	//funcion de consulta con la base. parametro el query
	public function consulta($consulta)
	{  
		$resultado = @mysqli_query($this->conexion,$consulta); 
		 
		if(!$resultado)
		{  
			throw new Exception('No Funciona la Consulta. El Error es el siguiente: '.mysqli_error());
		} else
		{
				return $resultado; 
		}
		
	}
	
	//funcion para la cracion de los array. paramentro el resultado de la consulta	  
	public function fetch_array($consulta)
	{   
		return @mysqli_fetch_array($consulta);  
		
	} 

	public function fetch_object($consulta)
	{
		return @mysqli_fetch_object($consulta);
	} 
				  
	public function fetch_row($consulta)
	{   
		return @mysqli_fetch_row($consulta);  
	}    
				  		  
	public function fetch_assoc($consulta)
	{   
		return @mysqli_fetch_assoc($consulta);  
	}  

	
	
	//funcion para obtener el todal de filas consultadas. parametro  resultado de la consulta
	public function num_rows($consulta)
	{   
		return @mysqli_stmt_num_rows($consulta);  
	}
	
	
	//funcion que obtiene el ultimo id que fue ingrsado
	public function id_ultimo()
	{
		return @mysqli_insert_id($this->conexion);  
	}  
	//preparando la base para insercion de datos
	public function begin()
    {
    	@mysqli_query("BEGIN");
    }
         
	public function commit()
    {
    	@mysqli_query("COMMIT");
    }
			  
	public function rollback()
    {
    	@mysqli_query("ROLLBACK");
    }
			 
	public function liberar($q)
    {   
    	@mysqli_free_result($q); 
    }
	
	public function cerrar($q)
	{
		@mysqli_close($q);
	}
}
?>