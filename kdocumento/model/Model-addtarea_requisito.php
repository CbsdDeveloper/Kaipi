<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
 
    $bd	         =	new Db ;
    $sesion 	 =  trim($_SESSION['email']);
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
     
    $accion              = $_GET['accion'];
    $idproceso_requi     = $_GET['idproceso_requi'];
    
    $idproceso          = $_GET['idproceso'];
    $idtarea            = $_GET['idtarea'];
    $requisito_perfil   = $_GET['requisito_perfil'];
    
 
    
    
    if ($accion == 'add'){
        
            $Aexiste = $bd->query_array('flow.wk_proceso_formulario_requi',
                                        'count(*) as nn', 
                                        'idproceso='.$bd->sqlvalue_inyeccion($idproceso,true).' and
                                         idtarea='.$bd->sqlvalue_inyeccion($idtarea,true).' and
                                         idproceso_requi='.$bd->sqlvalue_inyeccion($idproceso_requi,true)
                                        );
            
            if ($Aexiste['nn'] > 0) {
                
                $sql = "UPDATE flow.wk_proceso_formulario_requi
                           SET   requisito_perfil = ". $bd->sqlvalue_inyeccion(trim($requisito_perfil), true)." 
                         WHERE  idproceso=".$bd->sqlvalue_inyeccion($idproceso,true).' and
                                idtarea='.$bd->sqlvalue_inyeccion($idtarea,true).' and
                                idproceso_requi='.$bd->sqlvalue_inyeccion($idproceso_requi,true);
                
                $bd->ejecutar($sql);
                
                $DetalleRequisitos = 'ok... ya registrado '.$Aexiste['nn'] ;
                
            }else{   
                     
               $sql = "INSERT INTO flow.wk_proceso_formulario_requi(	idproceso, idtarea, idproceso_requi, sesion, requisito_perfil)
        										        VALUES (" .
        										        $bd->sqlvalue_inyeccion($idproceso, true).",".
        										        $bd->sqlvalue_inyeccion($idtarea, true).",".
        										        $bd->sqlvalue_inyeccion($idproceso_requi, true).",".
        										        $bd->sqlvalue_inyeccion($sesion, true).",".
        										        $bd->sqlvalue_inyeccion(trim($requisito_perfil), true).")";
        		  $bd->ejecutar($sql);
        		  
        		  $DetalleRequisitos= 'ok... datos procesados '.$Aexiste['nn'] . '-> '. $xx;
            } 
                
       }
       //--------------------------
       if ($accion == 'del'){
           
           $sql = "DELETE FROM  flow.wk_proceso_formulario_requi 
                   WHERE idtarearequi =" .  $bd->sqlvalue_inyeccion($_GET['id'], true);
        										      
           $bd->ejecutar($sql);
        										        
           $DetalleRequisitos = 'ok... datos Eliminado '.$Aexiste['nn'] ;
       }

       echo $DetalleRequisitos;
 
 

?>
 
  