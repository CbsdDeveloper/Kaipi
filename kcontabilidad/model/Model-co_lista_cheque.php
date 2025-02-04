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
            
            if ($estado == 'S'){
                              
                    $sql = "update co_asiento_aux 
                            set bandera = 1 
                            where id_asiento_aux=".$bd->sqlvalue_inyeccion($idaux, true).' and 
                                  registro= '.$bd->sqlvalue_inyeccion($registro, true);
            		              									      
            		$bd->ejecutar($sql);
                    
            }else{
                
                       
                $sql = "update co_asiento_aux
                            set bandera = 0
                            where id_asiento_aux=".$bd->sqlvalue_inyeccion($idaux, true).' and
                                  registro= '.$bd->sqlvalue_inyeccion($registro, true);
                
                $bd->ejecutar($sql);
            }
 
        }
        
}
 

 
 

?>
 
  