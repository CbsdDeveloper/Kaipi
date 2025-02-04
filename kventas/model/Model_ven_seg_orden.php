 <?php 
 session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    
    $idcliente          = trim($_GET['idcliente']);
    $razon              = trim($_GET['razon']);
    
    $idvengestion       = $_GET['idvengestion'];
  
    $hoy 	     =     date("Y-m-d");
    
    
    $sql = "SELECT count(*) as nn
              FROM ven_cotizacion
             WHERE modulo = 'orden'   and 
                   idvengestion =".$bd->sqlvalue_inyeccion($idvengestion,true) ;
/*
 
    #cliente
    #fecha
    #telefono
    #contacto
    */
    $contacto = $bd->query_array('ven_cliente',
        'telefono, correo, movil,contacto,direccion',
        'idvencliente='.$bd->sqlvalue_inyeccion($idcliente,true)
        );
    
 
    
    
     $resultado = $bd->ejecutar($sql);
     $contador  = $bd->obtener_array( $resultado);
    
   
    if ($contador['nn'] == 0 ){
        
        $AResultado = $bd->query_array('ven_registro',
            'orden_trabajo',
            'idven_registro='.$bd->sqlvalue_inyeccion(1,true)
            );
        
        $cadena = $AResultado['orden_trabajo'];
        
        $cabecera = str_replace("#cliente", $razon, $cadena);
        $cabecera = str_replace("#fecha",  $hoy, $cabecera);
        $cabecera = str_replace("#contacto",  trim($contacto['contacto']), $cabecera);
        $cabecera = str_replace("#telefono",  trim($contacto['telefono']).'-'.trim($contacto['movil']), $cabecera);
       
        $cabecera =  htmlspecialchars( $cabecera );
       
        $pie='';
        
         
        echo json_encode( 
                        array("a"=> $cabecera , 
                              "b"=> $pie ,
                              "c"=> '0'
                           )  
                        );
        
    }else{
        
        $sql = "SELECT id_cotizacion, fecha, modulo, idprov, razon, estado, cabecera, detalle, sesion, fecham
              FROM ven_cotizacion
             WHERE modulo = 'orden'  and
                   idvengestion =".$bd->sqlvalue_inyeccion($idvengestion,true) ;
        
        $resultado = $bd->ejecutar($sql);
        
        $dataProv  = $bd->obtener_array( $resultado);
        
        $cabecera =  htmlspecialchars( trim($dataProv['cabecera'])) ;
        
        $pie      =  ''; ;
        
        echo json_encode(
            array("a"=> $cabecera ,
                  "b"=> $pie ,
                  "c"=> trim($dataProv['id_cotizacion'])
                 )
            );
        
        
       
        
    }
     
?>