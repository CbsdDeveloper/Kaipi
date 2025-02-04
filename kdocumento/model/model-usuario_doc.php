<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
      
 
    $bd	   =	new Db ;
    
 
 
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
 
    $id                  =  $_GET['idcaso'];
    $sesion_dato         =  trim($_GET['sesion_dato']);
    $sesion 	         =  trim($_SESSION['email']);
 

    $datos =  $bd->__user($sesion_dato);
    $idprov = trim($datos['cedula']);
        
    $sqltarea = "UPDATE flow.wk_proceso_caso
        			        SET sesion =".$bd->sqlvalue_inyeccion($sesion_dato, true).",
                                elabora=".$bd->sqlvalue_inyeccion($sesion, true).",
                                idprov = ".$bd->sqlvalue_inyeccion($idprov, true)."
         				 WHERE idcaso =".$bd->sqlvalue_inyeccion($id, true). ' and
                               estado ='.$bd->sqlvalue_inyeccion('1', true);

    $bd->ejecutar($sqltarea);


    $sqltarea = "UPDATE  flow.wk_doc_user_temp
        			        SET sesion =".$bd->sqlvalue_inyeccion($sesion_dato, true)." 
         				 WHERE idcaso =".$bd->sqlvalue_inyeccion($id, true). ' and
                                sesion ='.$bd->sqlvalue_inyeccion($sesion, true);
    
                               
     $bd->ejecutar($sqltarea);                      
   

     $sqltarea = "UPDATE  flow.wk_proceso_casodoc
     SET sesion =".$bd->sqlvalue_inyeccion($sesion_dato, true).",
         elabora =".$bd->sqlvalue_inyeccion($sesion, true)." 
   WHERE idcaso =".$bd->sqlvalue_inyeccion($id, true). ' and
         uso ='.$bd->sqlvalue_inyeccion('I', true). ' and
         sesion ='.$bd->sqlvalue_inyeccion($sesion, true);

        
$bd->ejecutar($sqltarea);        



     
    
    
    echo 'INFORMACION ENVIADA CON EXITO...';
     
?>
 
  