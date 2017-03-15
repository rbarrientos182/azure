<?php
date_default_timezone_set('America/Mexico_City');
$datetime1 = date_create(date("H:i:s"));
$datetime2 = date_create("20:01:24");
$interval = date_diff($datetime1, $datetime2);
$hora = $interval->format("%H:%i:%S");
echo $hora;
