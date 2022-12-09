 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
  
    
    $sql = "SELECT   idproducto,pvp,saldo
				  FROM view_saldos_bod
				  where upper(producto)  || ' '  || trim(codigo) =".$bd->sqlvalue_inyeccion(trim($txtcodigo),true) ." AND 
				  registro = ".$bd->sqlvalue_inyeccion($registro,true);
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    $coe =  112/100;
    
    $precio = round($dataProv['pvp'] / $coe,2);
    
    echo json_encode( 
                     array("a"=>trim($dataProv['idproducto']), 
                           "b"=> $precio ,
                           "c"=> trim($dataProv['saldo']) 
                      )  
        );
       
    /*
    $resultado1 = $bd->ejecutar($sql);
    
    $datos_sql  = $bd->obtener_array( $resultado1);
    
    $idproducto= trim( $datos_sql['idproducto']);
    
    echo $idproducto;
    
                                  $("#idproducto").val( response.a );  
								 
								 $("#precio").val( response.b );  

								 $("#saldo").val( response.c );  
								 
     */
    
?>