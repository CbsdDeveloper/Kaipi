<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    $tarea          = $_GET['tarea'] ;
    $idproceso      = $_GET['idproceso'] ;
    $idcaso         = $_GET['idcaso'] ;
 
    $ATarea_flujo = $bd->query_array('flow.wk_proceso_formulario_user',
        '*',
        'idproceso='.$bd->sqlvalue_inyeccion($idproceso,true).' and
             idtarea='.$bd->sqlvalue_inyeccion($tarea ,true) .' and
             perfil='.$bd->sqlvalue_inyeccion('operador',true)
        );
    
    $unidad  = $ATarea_flujo['unidad'] ;
    
    if ( $tarea == '0')    {
        $unidad = '0' ;
    }
 
    
    if ( $unidad == '0')    {
        
        $unidad_actual                 = $bd->query_array('flow.view_proceso_caso','*',  "idcaso = ".$bd->sqlvalue_inyeccion( $idcaso  ,true) );
        $sesion                        = trim($unidad_actual['sesion']) ;
        
        $sql1 = "SELECT   email as codigo,completo as nombre
                               FROM  par_usuario
                   where estado= 'S' and email =".$bd->sqlvalue_inyeccion( $sesion ,true)   ;
        
    }else {
        
        $sql1 = "SELECT   email as codigo,completo as nombre
                        FROM  par_usuario
                       where  estado= 'S' and id_departamento =".$bd->sqlvalue_inyeccion( $unidad ,true)   ;
        
        
    }
    
 
   
    
    
    echo '<option value="0"> - Seleccione usuario responsable - </option>';
    

        $stmt1 = $bd->ejecutar($sql1);
         
        
        while ($fila=$bd->obtener_fila($stmt1)){
            
            echo '<option value="'.trim($fila['codigo']).'">'.trim($fila['nombre']).'</option>';
            
        }


?>