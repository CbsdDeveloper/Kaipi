<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db ;
 
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

if (isset($_POST["idproceso"]))	{
    
 
    $observa	          =     $_POST["procedimiento"];
    $idproceso		      =     $_POST["idproceso"];
    $accion               =     $_POST["accion"];
  
 
    
    if ( trim($accion) == 1 ){
             
            $sql = "UPDATE flow.wk_proceso
            		    SET procedimiento =".$bd->sqlvalue_inyeccion(trim($observa), true)." 
             		 WHERE  idproceso   =".$bd->sqlvalue_inyeccion($idproceso, true)      ;
            
             
            $bd->ejecutar($sql);
            
            $publicadoProceso = '<h5><b>Procedimiento publicado... actualizar la ventana para visualizar los cambios...</b><h5>';
            
            echo $publicadoProceso;
    }
    //------------------------2--
    if ( trim($accion) == 2 ){
        
      
        $x = $bd->query_array('flow.wk_proceso',   
            'procedimiento,imagen',                      
            'idproceso='.$bd->sqlvalue_inyeccion($idproceso,true)  
            );
        
        $publicadoProceso = $x["procedimiento"];
        
 
        echo json_encode(
            array("a"=> $publicadoProceso   ) 
            );
        
    }
    
    //------------------------2--
    if ( trim($accion) == 3 ){
        
        
        $x = $bd->query_array('flow.wk_proceso',
            'procedimiento,imagen',
            'idproceso='.$bd->sqlvalue_inyeccion($idproceso,true)
            );
        
        $publicadoProceso = $x["imagen"];
        
        
        echo json_encode(
            array("a"=> $publicadoProceso   )
            );
        
    }

    
    
    
}
 

 
?>
 
  