 <?php 
 session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
    
	$bd	   = new Db ;
	
 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    
    $idcliente          = trim($_GET['idcliente']);
    $razon              = trim($_GET['razon']);
    $idvengestion       = $_GET['idvengestion'];
    $hoy 	     =     date("Y-m-d");
    
    $sql1 = 'SELECT  count(*) as nn
                FROM ven_cliente_prod
                where idvengestion = '. $bd->sqlvalue_inyeccion($idvengestion , true) ;
   
    $resultadoD = $bd->ejecutar($sql1);
    $contador11  = $bd->obtener_array( $resultadoD);
    
    $contador1  = $contador11['nn'];
    //------------------
    
    $sql = "SELECT count(*) as nn
              FROM ven_cotizacion
             WHERE modulo = 'ordenp'   and 
                   idvengestion =".$bd->sqlvalue_inyeccion($idvengestion,true) ;
/*
 
    #cliente
    #fecha
    #telefono
    #contacto idvengestion
    */
    
    $contacto = $bd->query_array('par_ciu',
        'telefono, correo, movil,contacto,direccion',
        'idprov='.$bd->sqlvalue_inyeccion($idcliente,true)
        );
    
     
     $resultado = $bd->ejecutar($sql);
     
     $contador  = $bd->obtener_array( $resultado);
    
   
    if ($contador['nn'] == 0 ){
        
        $pie='';
         
        if ( $contador1 > 0 ){
            
            $cabecera = pone_plantilla(  $bd ,$obj ,$idvengestion,$razon ,$hoy,$contacto['contacto'],$contacto['telefono'],$contacto['movil']  );
            
            echo json_encode(
                array("a"=> $cabecera ,
                    "b"=> $pie ,
                    "c"=> '0'
                )
                );
            
        }else{
          
            echo json_encode(
            array("a"=> '' ,
                "b"=> '' ,
                "c"=> '0'
            )
            );
            
            
        }
 
        
    }else{
        
        $sql = "SELECT id_cotizacion, fecha, modulo, idprov, condicion_comercial,
                 razon, estado, cabecera, detalle, sesion, fecham
              FROM ven_cotizacion
             WHERE modulo = 'ordenp'  and
                   idvengestion =".$bd->sqlvalue_inyeccion($idvengestion,true) ;
        
        $resultado = $bd->ejecutar($sql);
        
        $dataProv  = $bd->obtener_array( $resultado);
        
        $cabecera =  htmlspecialchars( trim($dataProv['cabecera'])) ;
       
   
        if (empty(trim($dataProv['cabecera']))){
            $cabecera = pone_plantilla(  $bd ,$obj ,$idvengestion,$razon ,$hoy,$contacto['contacto'],$contacto['telefono'],$contacto['movil']  ) ;
        }
       
        
        //---------------------------------
        $pie      = trim($dataProv['condicion_comercial']);  
        
        echo json_encode(
            array("a"=> $cabecera ,
                  "b"=> $pie ,
                  "c"=> trim($dataProv['id_cotizacion'])
                 )
            );
        
  
        
    }
  //------
    function pone_plantilla( $bd ,$obj ,$idvengestion,$razon ,$hoy,$contacto,$telefono,$movil){
        
        $AResultado = $bd->query_array('ven_registro',
            'orden_trabajo',
            'idven_registro='.$bd->sqlvalue_inyeccion(1,true)
            );
        
        $cadena = $AResultado['orden_trabajo'];
        
        $cabecera = str_replace("#cliente", $razon, $cadena);
        $cabecera = str_replace("#fecha",  $hoy, $cabecera);
        $cabecera = str_replace("#contacto",  $contacto, $cabecera);
        $cabecera = str_replace("#telefono", $telefono.'-'.trim($movil), $cabecera);
        
        $tipo 		    = $bd->retorna_tipo();
        
        
        $sql = 'SELECT  cantidad, parcial as entregado, producto,detalle,precio
                FROM ven_cliente_prod
                where idvengestion = '. $bd->sqlvalue_inyeccion($idvengestion , true) ;
        
        
        $resultado  = $bd->ejecutar($sql);
        
        $dato_grid = $obj->grid->KP_GRID_EXCEL($resultado,$tipo) ;
        
        $cabecera = str_replace("#detalle",  $dato_grid, $cabecera);
        
        
        $cabecera =  htmlspecialchars( $cabecera );
        
        return $cabecera ;
        
    }
     
?>