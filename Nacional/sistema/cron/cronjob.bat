@echo off
start C:\wamp\bin\php\php5.3.13\php.exe C:\wamp\www\gepp\pagina\sistema\cron\orden.php
echo Ejecutando Script de php...
ping -n 5 127.0.0.1 > log.txt
exit