<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$codigo= $_GET['codigo'];
 

if ($codigo == 1){
    
    $sql1 ="SELECT idcatalogo as codigo, nombre
                            FROM  par_catalogo
                            WHERE  tipo = 'bancos'"   ;
    
}else{
    
    $sql1 ="SELECT idcatalogo as codigo, nombre
                            FROM  par_catalogo
                            WHERE  tipo = 'tarjetas'"   ;
    
}

 

$stmt1 = $bd->ejecutar($sql1);

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.$fila['nombre'].'</option>';
    
}





?>
								
 
 
 