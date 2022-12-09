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
    
 
    
    $long = strlen($observa);
    
    if ( $accion == 1 ){
        if ($long  > 20 ){
            
            $sql = " UPDATE flow.wk_proceso
            		    SET procedimiento =".$bd->sqlvalue_inyeccion(trim($observa), true)." 
             		 WHERE  idproceso   =".$bd->sqlvalue_inyeccion($idproceso, true)      ;
            
          
            
            $bd->ejecutar($sql);
            
            $publicadoProceso = '<h5><b>Procedimiento publicado... actualizar la ventana para visualizar los cambios...</b><h5>';
            
        }else{
            $publicadoProceso = '<h5><b> Debe ingresar el procedimiento mas detallada!!!</b><h5>';
        }
    }
    //------------------------2--
    if ( $accion == 2 ){
        
      
        $x = $bd->query_array('flow.wk_proceso',   // TABLA
            'procedimiento',                        // CAMPOS
            'idproceso='.$bd->sqlvalue_inyeccion($idproceso,true) // CONDICION
            );
        
        $publicadoProceso = $x["procedimiento"];
    }
    
    
    echo $publicadoProceso;
    
    
    
}
 

 
?>
 
  