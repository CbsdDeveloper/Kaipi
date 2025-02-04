<?php 
session_start( );
     
     require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
     require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
     
     
     $obj   = 	new objects;
     $bd	   =	new Db;
     
     $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
     
 
     $ruc = $_SESSION['ruc_registro'];
         
     $sql = "select id_rol , novedad  
								from nom_rol_pago
								where estado=".$bd->sqlvalue_inyeccion('N', true)."  and
								registro=".$bd->sqlvalue_inyeccion($ruc, true).' order by 1 desc';
     
    
     
     $stmt1 = $bd->ejecutar($sql);
     
     echo '<option value="-">'.'[ Seleccione Rol ]'.'</option>';
     
     while ($fila=$bd->obtener_fila($stmt1)){
         
         echo '<option value="'.$fila['id_rol'].'">'.$fila['novedad'].'</option>';
         
     }
     
   
 ?>
 
  