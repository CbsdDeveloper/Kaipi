 <?php 
 session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
    
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    
    $idcliente          = trim($_GET['idcliente']);
    $razon              = trim($_GET['razon']);
    $idvengestion       = ($_GET['idvengestion']);
  
     
        
        $sql = "SELECT id_cotizacion, fecha, modulo, idprov, condicion_comercial, estado, cabecera, detalle, sesion, fecham
              FROM ven_cotizacion
             WHERE modulo = 'orden'  and
                   idvengestion =".$bd->sqlvalue_inyeccion($idvengestion,true) ;
        
        $resultado = $bd->ejecutar($sql);
        
        $dataProv  = $bd->obtener_array( $resultado);
        
     //   $cabecera =  htmlspecialchars( trim($dataProv['cabecera'])) ;
        $cabecera =   ( trim($dataProv['cabecera'])) ;
        
        $pie      =  trim($dataProv['condicion_comercial']) ;
        
        echo json_encode(
            array("a"=> $cabecera ,
                  "b"=> $pie ,
                  "c"=> trim($dataProv['id_cotizacion'])
                 )
            );
        
 
     
?>