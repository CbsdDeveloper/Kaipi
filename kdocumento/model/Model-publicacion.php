<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db ;

$sesion 	 =  $_SESSION['email'];

$hoy 	     =  $bd->hoy();

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

if (isset($_GET["idproceso"]))	{
    
    
    $observa	          =     $_GET["observa"];
    $idproceso		      =     $_GET["idproceso"];
    $accion               =     $_GET["accion"];
    
    $long = strlen($observa);
    
    if ( $accion == 1 ){
        if ($long  > 20 ){
            
            $sql = " UPDATE flow.wk_proceso
            				  SET 	novedad      =".$bd->sqlvalue_inyeccion(trim($observa), true).",
            				        autorizado   =".$bd->sqlvalue_inyeccion($sesion, true).",
            						publica      =".$bd->sqlvalue_inyeccion( 'S', true).",
                                    fecha_autorizacion      =".$hoy.",
                                    fecha_modifica      =".$hoy."
            			 WHERE idproceso         =".$bd->sqlvalue_inyeccion($idproceso, true). ' and 
                               publica = '.$bd->sqlvalue_inyeccion('N', true)       ;
            
          
            
            $bd->ejecutar($sql);
            
            $publicadoProceso = '<h5><b>Proceso publicado... actualizar la ventana para visualizar los cambios...</b><h5>';
            
        }else{
            $publicadoProceso = '<h5><b> Debe ingresar novedad y/u observacion mas detallada!!!</b><h5>';
        }
    }
    //------------------------2--
    if ( $accion == 2 ){
        
        $sql = " UPDATE flow.wk_proceso
            				  SET 	publica      =".$bd->sqlvalue_inyeccion( 'N', true).",
                                    fecha_modifica      =".$hoy."
            			 WHERE idproceso         =".$bd->sqlvalue_inyeccion($idproceso, true). ' and
                               publica = '.$bd->sqlvalue_inyeccion('S', true)       ;
        
        
        
        $bd->ejecutar($sql);
        
        $publicadoProceso = '<h5><b>Proceso Revertido... actualizar la ventana para visualizar los cambios...</b><h5>';
        
    }
    
    
    echo $publicadoProceso;
    
    
    
}
 

 
?>
 
  