<?php 
   
    session_start( );   

	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/  
	require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
 
                $obj     = 	new objects;
                $bd	   =	new Db ;


    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
?>
 