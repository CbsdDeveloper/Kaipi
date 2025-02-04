<?php 
 session_start( );   
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
    
	$bd	   =    new Db ;
 
	
 	$bd->conectar_sesionWS();
	
	
	//$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $ruc    =  $_POST['vid'];
 
 
        
    $sql = "SELECT    cli_cedula,   cli_nombre_completo, cli_fecha_nacimiento
				  FROM cli_cliente
				  where  cli_cedula  =".$bd->sqlvalue_inyeccion(trim($ruc),true) ;
 
    /*
    $sql = "SELECT   idprov as cli_cedula, razon  as cli_nombre_completo, nacimiento as cli_fecha_nacimiento 
				  FROM par_ciu
				  where  idprov  =".$bd->sqlvalue_inyeccion(trim($ruc),true) ;
    */
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
    
    echo json_encode( 
                        array("a"=>trim($dataProv['cli_cedula']), 
                              "b"=> trim($dataProv['cli_nombre_completo']) ,
                              "c"=> trim($dataProv['cli_fecha_nacimiento']) ,
                        )  
            );
    
 
  
    
?>