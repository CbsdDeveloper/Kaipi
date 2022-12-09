<?php

$servidor = 'localhost';
$base_datos = 'RecoleccionBasura';
$usuario = 'postgres';
$password = 'desarrollo';


$link= pg_connect("host=".$servidor."   dbname=".$base_datos."  port=5432    user=".$usuario."  password=".$password);
 
echo $link;
?>