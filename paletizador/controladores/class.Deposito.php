<?php
include_once '../class/class.MySQL.php';

/**
 * clase paletizador
 */
class Deposito
{

  public function Index()
  {
     $db = new MySQL();
     $query = "SELECT * FROM Deposito";
     $result = $db->consulta($query);
     $row = $db->fetch_assoc($result);

     return $row;

  }
}
