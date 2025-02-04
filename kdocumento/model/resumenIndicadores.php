<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

  
function resumenIndicadores(){
    

    $obj     = 	new objects;
    $bd	   =	new Db ;
    
    $ruc       =    $_SESSION['ruc_registro'];
    $sesion 	 =  $_SESSION['email'];
   
    $datos = array();
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
      
    $A1 = $bd->query_array('view_proceso','count(*) as nro_indicadores', 'publica='.$bd->sqlvalue_inyeccion('S',true) );
    
    $datos['indicadores'] = $A1['nro_indicadores'] ;
   
    
    $where = 'publica = '. $bd->sqlvalue_inyeccion('S',true) ;
    $nro_registros = $bd->query_cursor_registros('view_proceso','unidad',$where,'group by unidad');
    
    $datos['indicadoresUnidad'] = $nro_registros;
    
    
    $A2 = $bd->query_array('view_proceso_caso','count(*) as nro_tramites', 'estado<>'.$bd->sqlvalue_inyeccion('5',true) );
    
    $datos['tramites'] = $A2['nro_tramites'] ;
    
 
    $A3 = $bd->query_array('view_proceso_caso','count(*) as nro_ejecucion', 'estado ='.$bd->sqlvalue_inyeccion('3',true) );
    
    $datos['ejecucion'] = $A3['nro_ejecucion'] ;
    
        
   
    return $datos;
 
 
}
?>
 
  