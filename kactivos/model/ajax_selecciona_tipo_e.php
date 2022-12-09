<?php

session_start( );

$tipo = trim($_GET["tipo"]);

if ( $tipo == 'BLD'){
    $_SESSION['TIPO_BIEN'] = '8';
 }else{
    $_SESSION['TIPO_BIEN'] = '0';
 }
$cadena = '<b>Clase Bien '.$tipo .'</b>';

echo  $cadena ;

?>
 
  