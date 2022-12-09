<?php 
session_start( );
     
     require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
     require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
     
     
 
     $bd	=	new Db;
     
     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     
     $monto    = $_GET['valor'];
     
     $id        = $_GET['id'];
     
     $accion    = trim($_GET['accion']);
     
     if ($accion == 'edit' ) {
         
         $sql = "UPDATE nom_rol_pagod
						   SET 	ingreso=".$bd->sqlvalue_inyeccion($monto, true)."
						 WHERE id_rold=".$bd->sqlvalue_inyeccion($id, true);
         
         $ViewSave =  'Editado '.$id;
     }
      
    
     if ($accion == 'del' ) {
         
         $sql = "DELETE FROM nom_rol_pagod  WHERE id_rold=".$bd->sqlvalue_inyeccion($id, true);
         
         $ViewSave =  'Eliminado '.$id;
         
     }
     
     $bd->ejecutar($sql);
 
   
     
     echo $ViewSave;
     
   
 ?>
 
  