<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   = new Db ;

$registro    = $_SESSION['ruc_registro'];
 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$id_concilia	 =	$_GET["id_concilia"];
$idaux	         =	$_GET["codigo"];
  
 
$EstadoTramite = $bd->query_array('co_concilia', 'estado', 'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true) );
   

if ( trim($EstadoTramite["estado"]) == 'digitado') {
    
    $sql = "update co_asientod
                            set concilia = 'S'
                            where id_asientod =".$bd->sqlvalue_inyeccion($idaux, true).' and
                                  registro= '.$bd->sqlvalue_inyeccion($registro, true);
    
     $bd->ejecutar($sql);
    
     
     $sql = "delete from  co_conciliad 
                   where id_asiento_aux=".$bd->sqlvalue_inyeccion($idaux, true).' and 
            id_concilia='.$bd->sqlvalue_inyeccion($id_concilia, true);
         
     $bd->ejecutar($sql);
        
}
 

?>