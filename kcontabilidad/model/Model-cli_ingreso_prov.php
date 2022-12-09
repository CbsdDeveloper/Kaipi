 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
	$idprov_original =  $_GET["idprov"] ;
	
	 
	 $long_original = strlen(trim($idprov_original));
	 
	 
	 if ($long_original == 10 ) {
 					
	 $ruc_nuevo = trim($idprov_original).'001';
		 
	 
	 $Avalida = $bd->query_array(
	     'par_ciu',
	     'count(*) as nn', 
	     'idprov='.$bd->sqlvalue_inyeccion($ruc_nuevo,true)
	     );
	 
		 
	 if ( $Avalida["nn"] == 0){
	     
	     
	     $sql = "UPDATE co_asiento_aux SET idprov = ".$bd->sqlvalue_inyeccion($ruc_nuevo,true).
	     " WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     $sql = "UPDATE co_asiento SET idprov = ".$bd->sqlvalue_inyeccion($ruc_nuevo,true).
	     " WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     $sql = "UPDATE co_compras SET idprov = ".$bd->sqlvalue_inyeccion($ruc_nuevo,true).
	     " WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     $sql = "UPDATE inv_movimiento SET idprov = ".$bd->sqlvalue_inyeccion($ruc_nuevo,true).
	     " WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     
	     $sql = "UPDATE par_ciu 
                 SET modulo = ".$bd->sqlvalue_inyeccion('P',true)." , idprov = ".$bd->sqlvalue_inyeccion($ruc_nuevo,true).
	     " WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     
	     echo '<script type="text/javascript">';
	     
	     echo  'LimpiarPantalla();';
	     
	     echo '</script>';
	     
	     $result = '<b>DATO ACTUALIZADO DEBE ACTUALIZAR LA PANTALLA PARA VISUALIZAR LA INFORMACION</b>';
	     
	     
	 }else{
	     //---- EXISTE INFORMACION
	     
	     $sql = "UPDATE co_asiento_aux SET idprov = ".$bd->sqlvalue_inyeccion($ruc_nuevo,true).
	            " WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
        
	     $bd->ejecutar($sql);
	     
	     $sql = "UPDATE co_asiento SET idprov = ".$bd->sqlvalue_inyeccion($ruc_nuevo,true).
	     " WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     $sql = "UPDATE co_compras SET idprov = ".$bd->sqlvalue_inyeccion($ruc_nuevo,true).
	     " WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
	     
	     $bd->ejecutar($sql);
	  
	     $sql = "UPDATE inv_movimiento SET idprov = ".$bd->sqlvalue_inyeccion($ruc_nuevo,true).
	     " WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     $sql = "delete from  par_ciu " .
	           " WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     echo '<script type="text/javascript">';
	     
	     echo  'LimpiarPantalla();';
	     
	     echo '</script>';
	     
	     $result = '<b>DATO ACTUALIZADO DEBE ACTUALIZAR LA PANTALLA PARA VISUALIZAR LA INFORMACION</b>';
	     
	   }
	 }else{
	     $result = '<b>NO SE PUEDE ACTUALIZAR LA INFORMACION DEL CLIENTE </b>';
	 }
	     
	 echo $result;
    
?>
 
  