 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $idproceso =  $_GET['idproceso'];
    
    
    $x = $bd->query_array('flow.wk_proceso',
        'solicitud',
        'idproceso='.$bd->sqlvalue_inyeccion($idproceso,true)
        );
    
  
    if ( $x['solicitud'] == 'P'){
        
        $y = $bd->query_array('par_usuario',
            'cedula,login, email,nomina',
            'email='.$bd->sqlvalue_inyeccion(trim( $_SESSION['email']),true)
            );
        
        
        $sql = "SELECT   idprov,razon
				  FROM par_ciu
				  where idprov  =".$bd->sqlvalue_inyeccion(trim($y['cedula']),true) ;
        
        
        $resultado1 = $bd->ejecutar($sql);
        
        $dataProv  = $bd->obtener_array( $resultado1);
        
        $idprov = trim($dataProv['idprov']);
        
        $nombre = trim($dataProv['razon']);
        
    }else{
        
        $idprov =  '';
        $nombre =  '';
        
        
    }
    
    echo json_encode(
        array("a"=>$idprov,
              "b"=> $nombre
             )
        );

    
?>