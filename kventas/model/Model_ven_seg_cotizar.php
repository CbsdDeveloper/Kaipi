 <?php 
 session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
    
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    
    $idcliente          = trim($_GET['idcliente']);
    $razon              = trim($_GET['razon']);
    $idvengestion       = ($_GET['idvengestion']);
    
    
  
    
    $sql = "SELECT count(*) as nn
              FROM ven_cotizacion
             WHERE modulo = 'preventa'  and 
                   idvengestion =".$bd->sqlvalue_inyeccion($idvengestion,true) ;

 
    
    $resultado = $bd->ejecutar($sql);
    
    $contador  = $bd->obtener_array( $resultado);
    
   
    if ($contador['nn'] == 0 ){
        
        $AResultado = $bd->query_array('ven_registro',
            'cotiza_det,cotiza_cab',
            'idven_registro='.$bd->sqlvalue_inyeccion(1,true)
            );
        
        $cadena = $AResultado['cotiza_cab'];
        $cabecera = str_replace("#cliente", $razon, $cadena);
        $pie =  $AResultado['cotiza_det'];
        
       
        $cabecera =  htmlspecialchars( $cabecera );
        $pie      =  htmlspecialchars( $pie );
        
         
        echo json_encode( 
                        array("a"=> $cabecera , 
                              "b"=> $pie ,
                              "c"=> '0'
                           )  
                        );
        
    }else{
        
        $sql = "SELECT id_cotizacion, fecha, modulo, idprov, razon, estado, cabecera, detalle, sesion, fecham
              FROM ven_cotizacion
             WHERE modulo = 'preventa'  and
                   idvengestion =".$bd->sqlvalue_inyeccion($idvengestion,true) ;
        
        $resultado = $bd->ejecutar($sql);
        
        $dataProv  = $bd->obtener_array( $resultado);
        
        $cabecera =  htmlspecialchars( trim($dataProv['cabecera'])) ;
        
        $pie      =  htmlspecialchars( trim($dataProv['detalle'])) ;
        
        echo json_encode(
            array("a"=> $cabecera ,
                  "b"=> $pie ,
                  "c"=> trim($dataProv['id_cotizacion'])
                 )
            );
        
        
       
        
    }
     
?>