<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
      
 
    $bd	   =	new Db ;
    
 
 
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    
    $accion       = trim($_GET['estado']);
    $id           = $_GET['id'];
    $tarea        = $_GET['tarea'];
 
    
    $sqltarea = "UPDATE flow.wk_proceso_casotarea
        			        SET cumple =".$bd->sqlvalue_inyeccion($accion, true).",
                                finaliza=".$bd->sqlvalue_inyeccion($accion, true)."
         				 WHERE idcaso =".$bd->sqlvalue_inyeccion($id, true). ' and
                               idcasotarea ='.$bd->sqlvalue_inyeccion($tarea, true);
    
    $bd->ejecutar($sqltarea);
    
    
    echo 'Estado de la tarea actualizada...';
     
?>
 
  