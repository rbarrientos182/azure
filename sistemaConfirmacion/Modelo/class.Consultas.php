<?php
class Consultas
{
  public function obtenerConfirmacion($inicio,$fin){
    if($inicio==null){
      $limit = null;
    }
    else {
      $limit = "LIMIT $inicio, $fin";
    }
    $rows = null;
    $modelo = new Conexion();
    $conexion = $modelo->getConexion();
    $sql = "SELECT
        a.pn_id,
        a.ds_nombre AS deposito,
        c.ds_nombre,
        c.ds_descripcion,
        IF(e.dd_fecha IS NULL,0,e.dd_fecha) AS dd_fecha,
        IF(e.dt_confirmacion IS NULL,0,e.dt_confirmacion) AS dt_confirmacion,
        IF(e.dt_inicio_despacho IS NULL,0,e.dt_inicio_despacho) AS dt_inicio_despacho,
        IF(e.dt_fin_despacho IS NULL,0,e.dt_fin_despacho) AS dt_fin_despacho
    FROM
        tconf_deposito a
            INNER JOIN
        tconf_deposito_mercado b ON b.fn_deposito_id = a.pn_id
            INNER JOIN
        tconf_mercado c ON c.pn_id = b.fn_mercado_id
            INNER JOIN
        tconf_operacion d ON d.fn_deposito_mercado_id = b.pn_id
            LEFT JOIN
        tdesp_bitacora e ON e.fn_operacion_id = d.pn_id
            AND e.dd_fecha = CURRENT_DATE
    ORDER BY c.ds_nombre , a.ds_nombre , c.ds_descripcion ASC $limit";
    $statement = $conexion->prepare($sql);
    $statement->execute();
    while($resultado = $statement->fetch()){
      $rows[] = $resultado;
    }
    return $rows;
  }//fin de  obtenerDeposito

  public function obtenerTotalDepositos(){
      $total = null;
      $modelo = new Conexion();
      $conexion = $modelo->getConexion();
      $sql = "SELECT COUNT(pn_id)AS total FROM tconf_deposito";
      $statement = $conexion->prepare($sql);
      $statement->execute();
      $resultado = $statement->fetchColumn();
      return $resultado;
  }// fin de obtenerTotalDepositos

}//fin de clase
