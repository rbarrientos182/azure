<?php 

echo $_FILES['fileInput']['size']; //tamaño en bytes del archivo recibido
echo '<br>';
echo $_FILES['fileInput']['type']; //tipo mime del archivo, por ejemplo image/gif
echo '<br>';
echo $_FILES['fileInput']['name']; //nombre original del archivo
echo '<br>';
echo $_FILES['fileInput']['tmp_name']; //nombre del archivo temporal que se utiliza para almacenar en el 

?>