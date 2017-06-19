<?php
class CambiosMotivos
{
 	private $motivo;
 	private $desMotivo;
 	private $producto;
  private $desProducto;
 	private $cantidad;
  private $nud;
  private $desCliente;
  private $fechaEntrega;
  private $fijo;
  private $productoConv;
  private $idRuta;

	function __construct()
	{
		if (!isset($_SESSION))
		{
			session_start();
		}

	}

	//getter
	public function getMotivos()
	{
		return $this->motivo;
	}

	public function getDesMotivo()
	{
		return $this->desMotivo;
	}

	public function getProducto()
	{
		return $this->producto;
	}

	public function getDesProducto()
	{
		return $this->desProducto;
	}

	public function getCantidad()
	{
		return $this->cantidad;
	}

	public function getFechaE(){
		return $this->fechaEntrega;
	}

	public function getFijo(){
		return $this->fijo;
	}

	public function getProductoConv(){
		return $this->productoConv;
	}

	public function getRuta(){
		return $this->idRuta;
	}

	//setter
	public function setMotivos($value)
	{
		 $this->motivo = $value;

	}

	public function setDesMotivo($value)
	{
		 $this->desMotivo = $value;

	}

	public function setProducto($value)
	{
		 $this->producto = $value;

	}

	public function setDesProducto($value)
	{
		 $this->desProducto = $value;

	}

	public function setCantidad($value)
	{
		 $this->cantidad = $value;

	}

	public function setNud($value)
	{
		 $this->nud = $value;

	}

	public function setDesCliente($value)
	{
		$this->desCliente = $value;
	}

	public function setFechaE($value){
		$this->fechaEntrega = $value;
	}

	public function setFijo($value){
		$this->fijo = $value;
	}

	public function setProductoConv($value){
		$this->productoConv = $value;
	}

	public function setRuta($value){
		$this->idRuta = $value;
	}

	// fin de getters y setters

	public function addCambiosMotivos()
	{

		//si trae un producto.... realizas esto...
		if(isset($_SESSION['itemsEnCesta']))
		{
			$itemsEnCesta = $_SESSION['itemsEnCesta'];
		}

        $b = $this->motivo;
        $b .= $this->producto;
        $b .= $this->nud;

		$itemsEnCesta[md5($b)] = array('id'=>md5($b),'idM'=>$this->motivo,'descripcionMotivo'=>$this->desMotivo,'sku'=>$this->producto,'descripcionProducto'=>$this->desProducto,'cantidad'=>$this->cantidad,'fechaE'=>$this->fechaEntrega,'productoConv'=>$this->productoConv, 'nud'=>$this->nud, 'desCliente'=>$this->desCliente/*, 'fijo'=>$this->fijo, 'ruta'=>$this->idRuta*/);
		$_SESSION['itemsEnCesta'] = $itemsEnCesta;

	}// fin método addCambiosMotivos

	public function delCambiosMotivos($valor)
	{
		if (isset($_SESSION['itemsEnCesta']))
		{
			$itemsEnCesta = $_SESSION['itemsEnCesta'];
            unset($itemsEnCesta[md5($valor)]);
			$_SESSION['itemsEnCesta'] = $itemsEnCesta;
		}

	}// fin método delCambiosMotivos

	public function mostrarTabla()
	{

		if(isset($_SESSION['itemsEnCesta']))
		{
			 $itemsEnCesta = $_SESSION['itemsEnCesta'];
			$cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		}
		else
		{
			 $itemsEnCesta = false;
		}
		if (isset($itemsEnCesta) && $cantidad>0) // validamos que la session de array exista y que contenga un producto
		{
		?>
			<div class="box-content">
			  	<table class="table table-striped table-bordered bootstrap-datatable datatable">
	                <tr>
	                  <th>Cliente</th>
					  <th>Motivo</th>
					  <th>Producto</th>
					  <th>Cantidad</th>
					  <!--<th>Ruta Entrega</th>-->
					  <th>Fecha Preventa</th>
					  <th>Producto Conversion</th>
					  <th>Acción</th>
					</tr>
					<?php
					$contador = 0;
			   		foreach($itemsEnCesta as $k => $v)
			   		{
		            ?>
					<tr>
						<td class="center" >
			            	<?php echo $v['desCliente']; ?>
			            </td>
			            <td class="center" >
			            	<?php echo $v['descripcionMotivo']; ?>
			            	<input name="codigop<?php echo $contador;?>" type="hidden" value="<?php echo $v['idM'].$v['sku'].$v['nud'];?>" id="codigop<?php echo $contador;?>">
			            	<input name="didproducto<?php echo $contador;?>" type="hidden" value="<?php echo $v['sku'];?>" id="didproducto<?php echo $contador;?>">
			            	<input name="didmotivos<?php echo $contador;?>" type="hidden" value="<?php echo $v['idM'];?>" id="didmotivos<?php echo $contador;?>">
			            	<input name="didcliente<?php echo $contador;?>" type="hidden" value="<?php echo $v['nud']?>"id="didcliente<?php echo $contador;?>">
			            	<input name="didfechae<?php echo $contador;?>" type="hidden" value="<?php echo $v['fechaE'];?>" id="didfechae<?php echo $contador;?>">
			            	<!--<input name="didfijo<?php echo $contador;?>" type="hidden" value="<?php echo $v['fijo']?>"id="didfijo<?php echo $contador;?>">-->
			            </td>
			            <td class="center">
			            	<?php echo $v['descripcionProducto']; ?>
			            </td>
						<td class="center">
							<input class="input-xlarge focused" name="cantidad<?php echo $contador;?>" id="cantidad<?php echo $contador;?>" onchange="actualizarCantidadMotivos(<?php echo $contador; ?>)"; type="text" value="<?php echo $v['cantidad'];?>">
			            </td>
			            <!--<td class="center">
			            	<?php echo $v['ruta']?>
			            </td>-->
			            <td class="center">
			            	<?php echo $v['fechaE']?>
			            </td>
			            <td>
			            	<?php echo $v['productoConv'];?>
			            </td>
			            <td  class="center">
			              <a class="btn btn-danger" onclick="eliminarMotivos(<?php echo $contador; ?>)" href="#">
	                      <i class="icon-trash icon-white"></i>Eliminar
			              </a>
			            </td>
					</tr>
					<?php
				    	$contador++;
			    	} // fin del for each
					?>
			   		<tr>
						<td colspan="7" class="center">
		                    <input type="submit" name="button" id="button" value=":: Guardar ::" <?php if($cantidad >0){?>onclick="guardarMotivos()"<?php } ?>>
		                </td>
	            	</tr>
				</table>
			</div>
		<?php
		 }
		 else
		 {
		?>
			<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
	    			<tr>
	      				<td class="center">No Existen Productos</td>
	    			</tr>
				</table>
			</div>
		<?php

		}

	}// fin método mostrarTabla

}
?>
