<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   = new Db ;

$registro    = $_SESSION['ruc_registro'];
 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id_concilia	 =	$_GET["id_concilia"];
$idaux	         =	$_GET["idaux"];
$estado	         =	$_GET["estado"];
$bandera	     =	$_GET["bandera"];
 

$EstadoTramite = $bd->query_array('co_concilia', 'estado', 'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true) );
   

if ( trim($EstadoTramite["estado"]) == 'digitado') {
    
        if ($bandera == 'S'){
            
         
                $sql = "update co_asientod
                    set concilia = ".$bd->sqlvalue_inyeccion(trim($estado), true)."
                   where id_asientod =".$bd->sqlvalue_inyeccion($idaux, true);
                      
             
               
            
            $bd->ejecutar($sql);
 
        }
        
}
 

 
 

?>
 
  