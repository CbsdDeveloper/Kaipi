<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
 
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $idproceso     = $_GET['idproceso'];
    $idtarea       = $_GET['idtarea'];
    $tipoAcceso    = $_GET['tipo'];
   
    $tipo 		= $bd->retorna_tipo();
    
 
    $sql = 'SELECT  
                    unidad  ,
                    ambito_proceso ,
                    reasignar ,
                    perfil ,
                    sesion,idtareaunidad
      FROM flow.view_unidadProcesotarea
      where idproceso = '.$bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '.$bd->sqlvalue_inyeccion($idtarea ,true)      ;
    
 
    
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Unidad,Ambito,Reasignar,Perfil";
    
    if ($tipoAcceso == 'V'){
        
        $evento   =  " ";
        $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
    
    }else{
    
        $evento   =  "delResponsable-5";
        $obj->table->table_basic_js($resultado,$tipo,'','del',$evento ,$cabecera);
    
    }
  
      
    $DetalleUnidad = 'ok';

    echo $DetalleUnidad;
 
 

?>