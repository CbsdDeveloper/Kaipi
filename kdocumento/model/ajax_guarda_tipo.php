<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    $valor    = $_GET['valor'] ;
    $tipo          = trim($_GET['tipo']) ;
    $codigo        = trim($_GET['codigo']) ;
 

    if ( $tipo == '1'){
        
         $sql1 = 'update   par_usuario
                    set inicial= '.$bd->sqlvalue_inyeccion($valor,true).' 
                    where idusuario= '.$bd->sqlvalue_inyeccion($codigo,true);
  
    }  

 
    if ( $tipo == '2'){
        
        $sql1 = 'update   par_usuario
                    set adicional= '.$bd->sqlvalue_inyeccion($valor,true).' 
                    where idusuario= '.$bd->sqlvalue_inyeccion($codigo,true);
        
    }  
     
    

  $bd->ejecutar($sql1);
 
 echo 'DATOS ACTUALIZADOS...';

?>