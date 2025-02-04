 <?php  
    session_start();  
 
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    $obj   = 	new objects;
	
	$bd	   =	 	new Db ;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
     
    $id_liquida     = $_GET['id_liquida'] ;
    
    $sesion 	     =  trim($_SESSION['email']);
    $ruc       =  $_SESSION['ruc_registro'];
    
    $accion         = trim($_GET['accion']) ;
    $tipo_iva       = $_GET['tipo'] ;
    $cantidad       = $_GET['cantidad'] ;
    $servicios      = $_GET['servicios'] ;
    $detalle_d      = strtoupper(trim($_GET['detalle_d'])) ;
    
    if (empty($id_liquida)){
        $id_liquida = -1;
    }
    
    if ( $accion == 'add'){

        if ( $tipo_iva == 'S'){
            
            $baseimpgrav   =  $cantidad * $servicios;
            $baseimponible = '0.00';
            $montoiva      =  round($baseimpgrav * 12/100,2);
            
        }else{
            $baseimpgrav = '0.00';
            $baseimponible  = $cantidad * $servicios;
            $montoiva  = '0.00';
        }
        
     
        
        $ATabla = array(
            array( campo => 'id_liquidad',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_liquida',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $id_liquida, key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $detalle_d, key => 'N'),
            array( campo => 'cantidad',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $cantidad, key => 'N'),
            array( campo => 'precio',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => $servicios, key => 'N'),
            array( campo => 'baseimponible',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor =>$baseimponible, key => 'N'),
            array( campo => 'baseimpgrav',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => $baseimpgrav, key => 'N'),
            array( campo => 'montoiva',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => $montoiva, key => 'N'),
            array( campo => 'registro',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $ruc, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
        );
        
        
         $bd->_InsertSQL('co_liquidacion_d',$ATabla,'co_liquidacion_id_liquida_seq');
 
    }
    
    if ( $accion == 'del'){
        $transaccion         = trim($_GET['transaccion']) ;
        $codigo              = $_GET['codigo'] ;
        
        if ( $transaccion == 'N'){
            $sql = 'delete from co_liquidacion_d  where id_liquidad='.$bd->sqlvalue_inyeccion($codigo, true);
            $bd->ejecutar($sql);
        }
        
    }
    
    
    
    $tipo 		     = $bd->retorna_tipo();
    // TIPO DE CONEXION DE BASE DE DATOS ... POSTGRES
    
   
    
    if ( $id_liquida == -1 ){
        $sql = "select id_liquidad, detalle, cantidad, precio, baseimponible, baseimpgrav, montoiva
            from co_liquidacion_d
            where id_liquida = ".$bd->sqlvalue_inyeccion($id_liquida, true). "  and 
                   sesion = ".$bd->sqlvalue_inyeccion($sesion, true). "  
            order by id_liquidad desc";
    }else{
        $sql = "select id_liquidad,  detalle, cantidad, precio, baseimponible, baseimpgrav, montoiva
            from co_liquidacion_d
            where id_liquida = ".$bd->sqlvalue_inyeccion($id_liquida, true). "
            order by id_liquidad desc";
    }
    
  
    
    $evento = 'Modifica_dliquida-0';
    $edita    = '';
    $del      = 'del';
    
    $cabecera =  "Id,Detalle,Cantidad,Precio,Base 12%,Monto IVA, Tarifa 0%"; // CABECERA DE TABLAR GRILLA HA VISUALIZAR
    
    
    $resultado  = $bd->ejecutar($sql);
    
    $obj->table->table_basic_seleccion($resultado,$tipo,$edita,$del,$evento ,$cabecera,'12');
?>

  