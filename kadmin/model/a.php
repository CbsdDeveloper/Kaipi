<?php
session_start( );

$_SESSION['datos_vista'];

$oldFile="inicio.txt"; 
$newFile="nuevo1.txt"; 
file_put_contents($newFile,str_replace('_nombre_cabecera',$_SESSION['nombre_archivo'],file_get_contents($oldFile)));

$oldFile="inicio.txt"; 
$newFile="nuevo1.txt"; 
file_put_contents($newFile,str_replace('_nombre_cabecera',$_SESSION['etiquetas_impresion'],file_get_contents($oldFile)));

    
    ?>					 
 
 
 