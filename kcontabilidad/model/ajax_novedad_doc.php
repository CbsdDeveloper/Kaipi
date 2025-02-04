<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 

$id 				    =     $_GET["id"];
$accion 				=     trim($_GET["accion"]);

 
if (  $accion  == 'del'){
    $sql1 = 'delete from co_control
              where id_control = '.$bd->sqlvalue_inyeccion($id,true)  ;


   echo 'Novedad eliminada con exito...';           
}


 
if (  $accion  == 'aprobar'){
 

    $sql1 = "update co_control 
                set estado = 'S'
               where id_control = ".$bd->sqlvalue_inyeccion($id,true) ;

               echo 'Información actuallizada con exito...';                    

}
 
  $bd->ejecutar($sql1);
  
    
        
 

?>
								
 
 