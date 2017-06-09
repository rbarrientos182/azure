<?php
include_once '../class/class.MySQL.php';

/**
 * clase paletizador
 */
class Paletizador
{

  function __construct(argument)
  {
    # code...
  }

  public function Index()
  {
     $conexion = new MySQL();

     $query = "SELECT * FROM Paletizador";
  }
}
