<?php 
session_start( );
     
     require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
     require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
     
 
     $bd	=	new Db;
     
     $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
     
     $id_rol    = $_GET['id_rol'];
     
     $idprov        = $_GET['idprov'];
 
     
     $AResultado = $bd->query_array('nom_rol_pago',
                                    'estado', 
         'id_rol='.$bd->sqlvalue_inyeccion($id_rol,true)
         );
     
     $ViewSave =  'Rol de la identificacion:'.$idprov.' No se puede eliminar';
     
     if ( trim($AResultado['estado']) == 'N' ){
         
         $sql = "DELETE FROM nom_rol_pagod
              WHERE id_rol=".$bd->sqlvalue_inyeccion($id_rol, true).' and
                    idprov = '.$bd->sqlvalue_inyeccion($idprov, true);
         
         
         $bd->ejecutar($sql);
         
         $ViewSave =  'Rol de la identificacion:'.$idprov.' eliminada';
     }
 
     
     
     
     echo $ViewSave;
     
   
 ?>
 
  