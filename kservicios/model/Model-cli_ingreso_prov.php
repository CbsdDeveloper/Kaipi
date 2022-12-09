 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
	$idprov_original =  trim($_GET["idprov"]) ;
	
	$Avalida_ori = $bd->query_array(
	    'par_ciu',
	    'id_par_ciu',
	    'idprov='.$bd->sqlvalue_inyeccion($idprov_original,true)
	    );
	
	
	$id_par_ciu_original = $Avalida_ori['id_par_ciu'];
	
	
	 $bandera = 0;
	 
	 $long_original = strlen(trim($idprov_original));
	 
	 if ($long_original == 10 ) {
	     
	     $ruc_nuevo = trim($idprov_original).'001';
	     
	     $Avalida = $bd->query_array(
	         'par_ciu',
	         'id_par_ciu',
	         'idprov='.$bd->sqlvalue_inyeccion($ruc_nuevo,true)
	         );
	     
	     $id_par_ciu_cambiar = $Avalida['id_par_ciu'];
	     

	     if (  $id_par_ciu_cambiar > 0 ) {
	         $bandera == 1;
 	     }
 	     
	 }
	     
	  	
		 
	 if ( $bandera == 1){
	     
	     
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
	     
	     
	     
	     
	     $sql = "UPDATE rentas.ren_movimiento SET id_par_ciu = ".$bd->sqlvalue_inyeccion($id_par_ciu_cambiar,true).
	     " WHERE id_par_ciu = ".$bd->sqlvalue_inyeccion($id_par_ciu_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     
	     $sql = "UPDATE rentas.ren_movimiento_pago SET id_par_ciu = ".$bd->sqlvalue_inyeccion($id_par_ciu_cambiar,true).
	     " WHERE id_par_ciu = ".$bd->sqlvalue_inyeccion($id_par_ciu_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     
	     $sql = "UPDATE rentas.ren_tramites SET id_par_ciu = ".$bd->sqlvalue_inyeccion($id_par_ciu_cambiar,true).
	     " WHERE id_par_ciu = ".$bd->sqlvalue_inyeccion($id_par_ciu_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     
	     
	     
	     $sql = "UPDATE par_ciu
                 SET razon =  '_valido ' || razon,
                    modulo = ".$bd->sqlvalue_inyeccion('X',true)."
                   WHERE idprov = ".$bd->sqlvalue_inyeccion($idprov_original,true);
	     
	     $bd->ejecutar($sql);
	     
	     
	     echo '<script type="text/javascript">';
	     
	     echo  'LimpiarPantalla();';
	     
	     echo '</script>';
	     
	     $result = '<b>DATO ACTUALIZADO DEBE ACTUALIZAR LA PANTALLA PARA VISUALIZAR LA INFORMACION</b>';
	     
	     
	 }
	 
	 
	  
	     
	 echo $result;
    
?>
 
  