 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   
    
    require '../../kconfig/Obj.conf.php'; 
	
 	$bd	   = new Db ;
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $valor_variable =  ($_GET['valor_variable']);
 
  
    
    $sql = "SELECT   variable, tipo, enlace, tabla,  lista
			  FROM flow.wk_variables
			 WHERE idvariable =".$bd->sqlvalue_inyeccion($valor_variable,true) ;
    
    $sql1 = "SELECT  variable, tipo, enlace, tabla,  lista
			  FROM flow.wk_proceso_variables
			 WHERE idproceso_var =".$bd->sqlvalue_inyeccion($valor_variable/1000,true) ;
    
    
    if ($valor_variable > 0){
        
        if ( $valor_variable > 1000 ){
            $resultado1 = $bd->ejecutar($sql1);
        }else{
            $resultado1 = $bd->ejecutar($sql);
        }
       
        
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