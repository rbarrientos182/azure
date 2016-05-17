<?php 
class Mail
{
	public $remitente = NULL;
	public $destinatario = NULL;
	public $mensaje = NULL;
	public $asunto = NULL;
	public $para = NULL;
	public $copia = NULL;
	public $copiaOculta = NULL;
	
	/*function __construct()
	{
		
	}*/

	public function enviarMail(){
		// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Cabeceras adicionales
		$cabeceras .= 'To: Karina Ortiz <karina@some.mx>'."\r\n";
		$cabeceras .= 'From: '.$nombre.' <'.$email.'>' . "\r\n";
    	$cabeceras .= 'Cc: roberto@some.mx' . "\r\n";
		$cabeceras .= 'Bcc: barrientos.isc@gmail.com' . "\r\n";

		// Mail it
		mail($this->destinatario, $this->asunto,$this->mensaje, $cabeceras);

	}
}







?>