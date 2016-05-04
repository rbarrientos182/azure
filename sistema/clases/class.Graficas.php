<?php
class Graficas
{	
	//variblesde informacion
	public $titulografica;//titulo de la grafica
	public $coloresdebarras;//colores de barras en formato hexadecimal Ej. 4D89F9,C6D9FD,C6D0FD
	public $dimensiones;//dimension de la ventana donde se visualizara la gráfica Ej. 850x250
	public $x1;//ejemplo  |1|2|3|4|5|6|7|8|9|10|11|12|13|
	public $x2;//ejemplo  |Dias|
	public $y1;//ejemplo  |100|200|300|400|500|600|700|800|900|1000|
	public $y2;//ejemplo  |Rangos|
	public $r1;//ejemplo  |0|$+500|1000|1500|2000|2500|3000|
	public $r2;//ejemplo  |probando|
	public $t1;//ejemplo  |titulo|
	public $t2;//ejemplo  |titulo arriba|
	public $vMax;//ejemplo el valor máximo de un promedio ejemplo 98.5
	public $vMin;//ejemplo el valor minimo de un promedio ejemplo 60.2
	public $valores;//ejemplo 10,40,15,10,11,15,48,78,78|12,45,78,1000|12,45,78,1000   cada grupo de barras esta separado por un |    
    public $cuadrosdeetiquetas;// etiquetas represntando el color de la barra eje plo   Visitas|Ventas
    public $anchosyespacios;//El primer numero ancho de la barra,separacion de las barras , separacion de los grupos  20,2,5
	public $etiquetaRebanada;//nombre que va a aparecer en la etiqueta por rebanada esto es unicamente para la grafia de pastel. Ejm. tu|yo|el|
	public $tipoPastel;//tipo de pastel a mostrar p- para pastel 2d p3- para pastel 3d
	public $EtiquetasBarras;//nombre que va ensima de las etiquetas de las barras Ejemplo    N,0033FF,0,-1,11|N,003300,1,-1,11

	//funcion para crear cadena y generar  la imagen de las graficas de barras
	public function Barras()
	 {
		 $link = "http://chart.googleapis.com/chart?chtt=".$this->titulografica."&cht=bvs&chco=".$this->coloresdebarras."&chs=".$this->dimensiones."&chxt=x,x,y,y,r,r,t,t&chxl=0:".$this->x1."1:".$this->x2."2:".$this->y1."3:".$this->y2."4:".$this->r1."5:".$this->r2."6:".$this->t1."7:".$this->t2."&chd=t:".$this->valores."&chxp=1,50|3,50&chdl=".$this->cuadrosdeetiquetas."&chbh=".$this->anchosyespacios."&chm=".$this->EtiquetasBarras."&chf=c,ls,90,EDEDED,0.15,FFFFFF,0.1";
		 
		 return $link;
		 
		 
     }
	 
	 //funcion para crear cadena y generar la imagen de las graficas de pastel
	 public function Pastel()
	 {
		 $link = "http://chart.googleapis.com/chart?chtt=".$this->titulografica."&cht=".$this->tipoPastel."&chco=".$this->coloresdebarras."&chs=".$this->dimensiones."&chxt=x&chd=t:".$this->valores."&chl=".$this->etiquetaRebanada."&chdl=".$this->cuadrosdeetiquetas;
		 
		 return $link;
	 }

	 public function unaFuncion()
	 {

		 $link = "https://chart.googleapis.com/chart?chtt=".$this->titulografica."&cht=lc&amp;chco=".$this->coloresdebarras."&amp;chs=".$this->dimensiones."&amp;chd=t:".$this->valores."&chds=".$this->vMin.",".$this->vMax."&amp;chxt=x,x,y,y&amp;chxl=0:".$this->x1."1:".$this->x2."2:".$this->y1."3:".$this->y2;

	 	return $link;
	 }	
	 
	public function ObtenerPromedio($total,$valor)
	{
		if($valor != 0 )
		{ 
			$promedio = ($valor * 100) / $total;    
		}
		else
		{
			$promedio = 0;
		}
		return $promedio; 
	}

	/*public function ObtenerRango($valor)		    
	{
		$rango = $valor / 10;						
		$contador = 0;
		$cadena = "|";
		
		for($i =0 ; $i <=10;$i++)
		{
			$cadena .= $contador. "|";  
			$contador= round($contador + $rango);
		}	
	return $cadena;
	}*/
	
	public function ObtenerRango($valor)		    
	{

		if($valor>10)
		{		
			$rango = $valor / 10;			
			$contador = 0;
			$contador2 = 0;
			$cadena = "|";
			
			for($i =0 ; $i <=10;$i++)
			{
				$cadena .= $contador2. "|"; 
				$contador= $contador + $rango;
				$contador2 = round($contador);
			}
		}
		else
		{
			$cadena = "|0|1|2|3|4|5|6|7|8|9|10|";
		}
	return $cadena;
	}
	 
}
?>