<?php

$achivo = 'spi-sp.txt';

//file_put_contents($achivo, 'Generacion Archivo');

echo hash_file('md5',$achivo);
 

 
require 'pclzip.lib.php';    

 
//   Creamos un objeto con el nombre del fichero a crear 

$archivo = new PclZip( "spi-sp.zip" );


// Podemos especificar los archivos pasandolos como un arreglo  
$nuevos_archivos = array( "spi-sp.txt" , "spi-sp.md5" );

$agregar = $archivo->create($nuevos_archivos );

 

// Gestionar error ocurrido (si $archivo->add() retorna cero a $agregar) 
if ( !$agregar ) {
    echo "ERROR. Codigo: ".$archivo->errorCode()." ";
    echo "Nombre: ".$archivo->errorName()." ";
    echo "Descripcion: ".$archivo->errorInfo();
} else {
    echo "Archivos agregados exitosamente!";
}
 
?>