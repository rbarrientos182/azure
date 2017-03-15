<?php
class Conexion
{
  private $conexion = null;
  private $user = "cronos";
  private $pass = "choruss";
  //private $host = "10.54.3.132";
  private $host = "localhost";
  private $db = "cronos";

  public function getConexion(){
    try {
      $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->db",$this->user,$this->pass);
      return $this->conexion;
    } catch (Exception $e) {
      die('Error: '.$e->GetMessage());
    }
  }
}
