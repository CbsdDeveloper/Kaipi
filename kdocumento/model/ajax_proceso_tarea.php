<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    $codigo    = $_GET['codigo'] ;
    $tipo      = $_GET['tipo'] ;
    $id        = $_GET['id'] ;
    
    
    if ( $tipo == '0'){
        
         $sql1 = 'select  idtarea as codigo,tarea as nombre
                    FROM flow.proceso_tarea_caso
                    where idproceso= '.$bd->sqlvalue_inyeccion($codigo,true).' and 
                          idcaso= '.$bd->sqlvalue_inyeccion($id,true)." and
                          cumple <> 'S'     
                    order by idtarea";
  
    }  

    
    if ( $tipo == '3'){
        
        $sql1 = 'select  idtarea as codigo,tarea as nombre
                    FROM flow.proceso_tarea_caso
                    where idcaso= '.$bd->sqlvalue_inyeccion($id,true)." 
                    order by idtarea";
        
    }  
    
    if ( $tipo == '1'){
  
        
        $sql1 = 'SELECT id_departamento as codigo,departamento as nombre
                FROM flow.view_proceso_user
                group by id_departamento,departamento 
                order by 2';
  
        echo '<option value="-">- 01. Seleccionar Unidad Responsable -</option>';
    }

    
    if ( $tipo == '2'){
        
        if ( $codigo == '-'){
            $codigo = '0';
        }
        
        $sql1 = "SELECT email as codigo,completo as nombre
                FROM flow.view_proceso_user
                where id_departamento = ".$bd->sqlvalue_inyeccion($codigo,true)." 
                order by 1";
 
 
        
        echo '<option value="-">[ 01. Seleccionar Responsable ]</option>';
    }
    

$stmt1 = $bd->ejecutar($sql1);
 

while ($fila=$bd->obtener_fila($stmt1)){
    
    if ( $tipo == '1'){
        if ( $fila['codigo'] == '0'){
            echo '<option value="-">- 02. Seleccionar Todas las unidades -</option>';
        }else{
            echo '<option value="'.trim($fila['codigo']).'">'.trim($fila['nombre']).'</option>';
        }
    }else{
        echo '<option value="'.trim($fila['codigo']).'">'.trim($fila['nombre']).'</option>';
        
    }
    
}


?>