 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	$idvengrupo     = $_GET['idvengrupo'];
	
	
	$sql = "SELECT idresponsable, completo  FROM  view_venta_zona where idvengrupo=".$idvengrupo;
 
  	 	 
    $stmt = $bd->ejecutar($sql);
		    
   echo '<option value="">'.'[Seleccione Responsable]'.'</option>';
  
   while ($fila=$bd->obtener_fila($stmt)){
      
      echo '<option value="'.$fila['idresponsable'].'">'.$fila['completo'].'</option>';
      
  }
    
   
 
?>
 
  