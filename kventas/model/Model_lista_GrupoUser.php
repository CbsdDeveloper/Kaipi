 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	$sesion 	 =     $_SESSION['email'];
	
	$id			 =     $_GET["id"];
	
 
	
    $sql = "SELECT idusuario, completo
            FROM view_ventas_grupo
            where idusuario  <> ".$bd->sqlvalue_inyeccion($id,true);
             
     $stmt = $bd->ejecutar($sql);
		    
   echo '<option value="">'.'[Seleccione Usuario]'.'</option>';
  
   while ($fila=$bd->obtener_fila($stmt)){
      
      echo '<option value="'.$fila['idusuario'].'">'.$fila['completo'].'</option>';
      
  }
    
 
    
?>
 
  