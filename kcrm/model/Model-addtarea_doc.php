<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
 
     $bd	   =	new Db ;
    
     $sesion 	 =  trim($_SESSION['email']);
   
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
     
    $accion = $_GET['accion'];
    
    
    $accion             = $_GET['accion'];
    $idproceso_docu     = $_GET['idproceso_docu'];
    
    $idproceso          = $_GET['idproceso'];
    $idtarea            = $_GET['idtarea'];
    $requisito_perfil   = $_GET['perfil_documento'];
    
    
    
    
    
    if ($accion == 'add'){
        
            $Aexiste = $bd->query_array('flow.wk_proceso_formulario_doc',
                                        'count(*) as nn', 
                                       'idproceso='.$bd->sqlvalue_inyeccion($idproceso,true).' and
                                        idtarea='.$bd->sqlvalue_inyeccion($idtarea,true).' and
                                        idproceso_docu='.$bd->sqlvalue_inyeccion($idproceso_docu,true)
                                        );
            
 
            
            if ($Aexiste['nn'] > 0) {
                
                $sql = "UPDATE flow.wk_proceso_formulario_doc
                           SET   perfil_documento = ". $bd->sqlvalue_inyeccion(trim($requisito_perfil), true)."
                         WHERE  idproceso=".$bd->sqlvalue_inyeccion($idproceso,true).' and
                                idtarea='.$bd->sqlvalue_inyeccion($idtarea,true).' and
                                idproceso_docu='.$bd->sqlvalue_inyeccion($idproceso_docu,true);
                
                $bd->ejecutar($sql);
                 
                $DetalleRequisitos = 'ok... ya registrado '.$Aexiste['nn'] ;
                
            }else{   
                     
               $sql = "INSERT INTO flow.wk_proceso_formulario_doc(	idproceso, idtarea, idproceso_docu, sesion, perfil_documento)
        										        VALUES (" .
        										        $bd->sqlvalue_inyeccion($idproceso, true).",".
        										        $bd->sqlvalue_inyeccion($idtarea, true).",".
        										        $bd->sqlvalue_inyeccion($idproceso_docu, true).",".
        										        $bd->sqlvalue_inyeccion($sesion, true).",".
        										        $bd->sqlvalue_inyeccion(trim($requisito_perfil), true).")";
        		  $bd->ejecutar($sql);
        		  
        		  $DetalleRequisitos= 'ok... datos procesados '.$Aexiste['nn'] . '-> '. $xx;
            } 
                
       }
       //--------------------------
       if ($accion == 'del'){
           
           $sql = "DELETE FROM  flow.wk_proceso_formulario_doc 
                   WHERE idtareadoc =" .  $bd->sqlvalue_inyeccion($_GET['id'], true);
        										      
           $bd->ejecutar($sql);
        										        
           $DetalleRequisitos = 'ok... datos Eliminado '.$Aexiste['nn'] ;
       }

       echo $DetalleRequisitos;
 
 

?>
 
  