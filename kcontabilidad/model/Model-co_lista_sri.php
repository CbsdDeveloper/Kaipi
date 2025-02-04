<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   = new Db ;

$registro    = $_SESSION['ruc_registro'];
 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


 
$idaux	         =	$_GET["idaux"];
$estado	         =	$_GET["estado"];
$bandera	     =	$_GET["bandera"];

$bandera	     =	$_GET["bandera"];
$proveedor       =	trim($_GET["proveedor"]);
 
    
        if ($bandera == 'S'){
            
            if ($estado == 'S'){
                              
                    $sql = "update co_asiento_aux 
                            set bandera = 1 , cab_codigo=9
                            where id_asientod=".$bd->sqlvalue_inyeccion($idaux, true).' and 
                                  idprov='.$bd->sqlvalue_inyeccion($proveedor, true).' and 
                                  registro= '.$bd->sqlvalue_inyeccion($registro, true);
            		              									      
            		$bd->ejecutar($sql);
                    
            }else{
                
                       
                $sql = "update co_asiento_aux
                            set bandera = 0, cab_codigo=0
                            where id_asientod=".$bd->sqlvalue_inyeccion($idaux, true).' and
                                  idprov='.$bd->sqlvalue_inyeccion($proveedor, true).' and 
                                  registro= '.$bd->sqlvalue_inyeccion($registro, true);
                
                $bd->ejecutar($sql);
            }
 
        }
        
 
 
 

?>
 
  