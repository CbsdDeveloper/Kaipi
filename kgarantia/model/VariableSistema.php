 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
    
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $valor_variable =  ($_GET['valor_variable']);
 
    
    $sql = "SELECT   variable, tipo, enlace, tabla,  lista
				  FROM wk_variables
				  where idvariable =".$bd->sqlvalue_inyeccion($valor_variable,true) ;
    
    
    if ($valor_variable > 0){
        
        $resultado1 = $bd->ejecutar($sql);
        
        $dataProv  = $bd->obtener_array( $resultado1);
        
        
        echo json_encode( array("a"=>trim($dataProv['variable']), 
                                "b"=> trim($dataProv['tipo']),
                                "c"=> trim($dataProv['enlace']),
                                "d"=> trim($dataProv['tabla']),
                                "e"=> trim($dataProv['lista']) 
                                )  
            
                        );
    }
    

    
 
  
    
?>