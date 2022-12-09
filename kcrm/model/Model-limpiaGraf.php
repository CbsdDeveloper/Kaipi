<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db ;

 
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

if (isset($_GET["idproceso"]))	{
    
    
     $idproceso		      =     $_GET["idproceso"];
     
     $long = 0;
 
     $An1 = $bd->query_array('flow.wk_proceso_caso',
                             'count(*) as n1', 
                            'idproceso='.$bd->sqlvalue_inyeccion($idproceso,true));
     
    // $An2 = $bd->query_array('flow.wk_proceso_formulario','count(*) as n2', 'idproceso='.$bd->sqlvalue_inyeccion($idproceso,true));
     
     $long = $An1["n1"]  ;
 
     $result = 'Dato '.$long;
   
    if ($long  == 0 ){
        
        $sql = "delete from flow.wk_procesoflujo
        			 WHERE idproceso =".$bd->sqlvalue_inyeccion($idproceso, true)    ;
        
        $bd->ejecutar($sql);
        
        $result = '<b>Flujo eliminado, cargue de nuevo el grafico al sistema</b>';
        
    }else{
        $result = '<b>No se puede eliminar la informacion del grafico</b>';
    }
 
    echo $result;
    
    
    
}
 
?>