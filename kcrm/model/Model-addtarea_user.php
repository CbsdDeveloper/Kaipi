<?php
session_start( );

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php';  

     
    $bd	   =	new Db ;
    
    $sesion 	 =  trim($_SESSION['email']);
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     
    $accion = $_GET['accion'];
    
    if ($accion == 'add'){
        
            $Aexiste = $bd->query_array('flow.wk_proceso_formulario_user',
                                        'count(*) as nn', 
                                        'idproceso='.$bd->sqlvalue_inyeccion($_GET['idproceso'],true).' and
                                        idtarea='.$bd->sqlvalue_inyeccion($_GET['idtarea'],true).' and
                                        unidad='.$bd->sqlvalue_inyeccion($_GET['unidad'],true)
                                        );
            
            if ($Aexiste['nn'] > 0) {
                
                $DetalleUnidad = 'ok... ya registrado '.$Aexiste['nn'] ;
                
            }else{   
               $sql = "INSERT INTO flow.wk_proceso_formulario_user(	idproceso, idtarea, unidad, sesion, ambito_proceso, reasignar, perfil)
        										        VALUES (" .
        										        $bd->sqlvalue_inyeccion($_GET['idproceso'], true).",".
        										        $bd->sqlvalue_inyeccion($_GET['idtarea'], true).",".
        										        $bd->sqlvalue_inyeccion($_GET['unidad'], true).",".
        										        $bd->sqlvalue_inyeccion($sesion, true).",".
        										        $bd->sqlvalue_inyeccion($_GET['ambito_proceso'], true).",".
         										        $bd->sqlvalue_inyeccion($_GET['reasignar'], true).",".
        										        $bd->sqlvalue_inyeccion($_GET['perfil'], true).")";
        		  $bd->ejecutar($sql);
        		  
        		  $DetalleUnidad = 'ok... datos procesados '.$Aexiste['nn'] ;
            } 
                
       }
       //--------------------------
       if ($accion == 'del'){
           
           $sql = "DELETE FROM  flow.wk_proceso_formulario_user 
                   WHERE idtareaunidad =" .  $bd->sqlvalue_inyeccion($_GET['id'], true);
        										      
           $bd->ejecutar($sql);
        										        
        	$DetalleUnidad = 'ok... datos Eliminado '.$Aexiste['nn'] ;
       }

        echo $DetalleUnidad;
 
 

?>
 
  