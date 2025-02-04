<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
	$sesion 	 =     $_SESSION['email'];
	
	
    $sql = "SELECT idvengrupo, grupo
            FROM view_ventas_grupo
            where email =".$bd->sqlvalue_inyeccion($sesion,true);
             
     $stmt = $bd->ejecutar($sql);
		    
   echo '<option value="">'.'[Seleccione Grupo]'.'</option>';
  
   while ($fila=$bd->obtener_fila($stmt)){
      
      echo '<option value="'.$fila['idvengrupo'].'">'.$fila['grupo'].'</option>';
      
  }
    
 
    
?>
 
  