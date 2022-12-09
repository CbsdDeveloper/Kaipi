<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$pillaro = new Db;



$local= '127.0.0.1';
$base_datos='pillaro';
$usuario='postgres';
$password='joseandres';

$pillaro->conectar_sesion_ventas($local, $base_datos,$usuario,$password);
  
$response = 'Datos procesados';

 
$fecha1         = $_GET['fecha'] ;

$response =  Selecciona_agua($fecha1,$pillaro,$bd);
    
  
echo $novedad1.' '.$response;


/*

INSERTA TRANSACCIONES DE AGUA

*/
function Selecciona_agua( $fecha1,$pillaro,$bd){
    
    $sql = "SELECT id_factura, codigo, usuario, cedula, ano, periodo, consumo, servicio, alcanta, cambionombre, sesiones, 
                   peones, notificacion, instalacion, arreglos, multas, mejoras, total, fecha_fac, hora_fac, cobrar, usuarioc, estado_fe
       FROM agua.view_facturafe
                    where
                    fecha_fac   = ".$pillaro->sqlvalue_inyeccion( $fecha1 ,true)." and
                    estado_fe <> ".$pillaro->sqlvalue_inyeccion( 'SI' ,true)."  order by codigo ";
    
    
    
    $stmt = $pillaro->ejecutar($sql);
    
    $i = 1 ;
    
    while ($fila=$pillaro->obtener_fila($stmt)){
        
        $id = trim($fila['cedula']);
        
        $valida = valida( $bd,$id);
        
        if ( $valida == 0 ){
            inserta_ciu($bd,$fila);
        };
        
        inserta_facturas($fila,$bd,$pillaro,'agua');
        
        $i++;
    }
    
    $response = 'Registros '.$i;
    
    return $response;
}

/*
inserta ciu
*/
function inserta_ciu( $bd,$fila ) {
    
    $id      =     trim($fila["cedula"]);
    $sesion  =     trim($_SESSION['email']);
    $nombre  =     trim($fila["usuario"]);
    
    $ATabla = array(
        array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => $id,   filtro => 'N',   key => 'S'),
        array( campo => 'razon',    tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor =>  $nombre,   filtro => 'N',   key => 'N'),
        array( campo => 'tipo',     tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
        array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'N',   valor => 'No definido',   filtro => 'N',   key => 'N'),
        array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'N',   valor => '02999999',   filtro => 'N',   key => 'N'),
        array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => 'comercial@hotmail.com',   filtro => 'N',   key => 'N'),
        array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'N',   valor => '02999999',   filtro => 'N',   key => 'N'),
        array( campo => 'idciudad',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => '18',   filtro => 'N',   key => 'N'),
        array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'SN',   filtro => 'N',   key => 'N'),
        array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'N',   valor => '0000',   filtro => 'N',   key => 'N'),
        array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'N',    valor =>'comercial@hotmail.com',   filtro => 'N',   key => 'N'),
        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'N',     valor => 'S',   filtro => 'N',   key => 'N'),
        array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
        array( campo => 'registro',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'S',   valor =>trim( $_SESSION['ruc_registro']),   filtro => 'N',   key => 'N'),
        array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'N',     valor => 'C',   filtro => 'N',   key => 'N'),
        array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'N',   valor => 'NN',   filtro => 'N',   key => 'N'),
        array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '16',  add => 'S',   edit => 'S',       valor =>  $sesion,   filtro => 'N',   key => 'N'),
    );
    
    $tabla 	  	  = 'par_ciu';
    
    $bd->_InsertSQL($tabla,$ATabla, $id );
}
/*
periodo
*/
function periodo($bd,$fecha ){
    
    $anio = substr($fecha, 0, 4);
    $mes  = substr($fecha, 5, 2);
    
    $APeriodo = $bd->query_array('co_periodo',
        'id_periodo, estado',
        'registro='.$bd->sqlvalue_inyeccion(trim( $_SESSION['ruc_registro']),true). ' AND
											  mes = '.$bd->sqlvalue_inyeccion($mes,true). ' AND
											  anio ='.$bd->sqlvalue_inyeccion($anio,true)
        );
    
    
     
    return $APeriodo['id_periodo'];
    
}
/*
*/
function inserta_facturas( $fila,$bd,$pillaro,$modulo){
    
 

 
    $fecha                   =  $fila["fecha_fac"];
    $fecha                   =  date('Y-m-d');
    
    $idperiodo               =  periodo($bd,$fecha);
    $detalle                 =  'Servicio de Agua Potable y Alcantarillado periodo '.$fila["ano"] .'-'.$fila["periodo"]. ' Consumo:'.$fila["consumo"];

 

    $otros       =  $fila["cambionombre"] +  $fila["sesiones"] +  $fila["peones"]  +  $fila["instalacion"] +  $fila["multas"] +  $fila["mejoras"] +  $fila["arreglos"] ;
    $servicio    =  $fila["servicio"]  ;
    $alcanta     =  $fila["alcanta"]   ;

    $base0    =   $servicio +  $otros + $alcanta  ;

    $total    =   $fila["total"]   ;

    $diferencia =     $total -  $base0 ;
    $otros      =     $otros  +  $diferencia;

    $documento =  $fila["id_factura"];
    
    $baseiva      = '0.00';
    $monto_iva    = '0.00';
    
    $usuarioc    = trim($fila["usuarioc"]);
    $sesion 	 =  trim($_SESSION['email']);
   
    if (empty($usuarioc)){
        $usuarioc = $sesion ;
        
    }
  
    
    $comprobante = K_comprobante($bd );
    
    $ATabla = array(
        array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
        array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor =>$fecha,   filtro => 'N',   key => 'N'),
        array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => trim( $_SESSION['ruc_registro']),   filtro => 'N',   key => 'N'),
        array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => $detalle,   filtro => 'N',   key => 'N'),
        array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor =>$usuarioc ,   filtro => 'N',   key => 'N'),
        array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $fecha,   filtro => 'N',   key => 'N'),
        array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'N',   valor => $comprobante,   filtro => 'N',   key => 'N'),
        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'aprobado',   filtro => 'N',   key => 'N'),
        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'F',   filtro => 'N',   key => 'N'),
        array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor =>$idperiodo,   filtro => 'N',   key => 'N'),
        array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => $documento,   filtro => 'N',   key => 'N'),
        array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => trim($fila["cedula"]),   filtro => 'N',   key => 'N'),
        array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
        array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'S',   edit => 'N',   valor =>$fecha,   filtro => 'N',   key => 'N'),
        array( campo => 'cierre',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'N',   valor => 'S',   filtro => 'N',   key => 'N'),
        array( campo => 'base12',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'S',   valor => $base12,   filtro => 'N',   key => 'N'),
        array( campo => 'iva',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => $iva,   filtro => 'N',   key => 'N'),
        array( campo => 'base0',   tipo => 'NUMBER',   id => '17',  add => 'S',   edit => 'S',   valor => $base0,   filtro => 'N',   key => 'N'),
        array( campo => 'total',   tipo => 'NUMBER',   id => '18',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
        array( campo => 'idbodega',   tipo => 'NUMBER',   id => '19',  add => 'S',   edit => 'S',   valor => '99',   filtro => 'N',   key => 'N'),
        array( campo => 'comision',   tipo => 'NUMBER',   id => '20',  add => 'S',   edit => 'N',   valor =>'99',   filtro => 'N',   key => 'N'),
        array( campo => 'idproceso',   tipo => 'NUMBER',   id => '21',  add => 'S',   edit => 'N',   valor =>$fila["periodo"],   filtro => 'N',   key => 'N'),
        array( campo => 'cab_codigo',   tipo => 'NUMBER',   id => '22',  add => 'S',   edit => 'N',   valor =>$fila["ano"],   filtro => 'N',   key => 'N'),
        array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '23',  add => 'S',   edit => 'N',   valor =>$modulo,   filtro => 'N',   key => 'N')
    );
    
     
     $tabla 	  	  = 'inv_movimiento';

     if (  $total  > 0  ) {

            $id_movimiento      = $bd->_InsertSQL($tabla,$ATabla, '-' );
        
            $idproducto  =  801; // servicios 
            if (  $servicio > 0  ){
                detalle_movi( $bd ,$id_movimiento,$idproducto,$baseiva,$monto_iva,  $servicio );
            }

            $idproducto  =  802; // alcantarillado 
            if (  $alcanta > 0  ){
                detalle_movi( $bd ,$id_movimiento,$idproducto,$baseiva,$monto_iva,  $alcanta );
            }

            $idproducto  =  803; // otros 
            if (  $otros > 0  ){
                detalle_movi( $bd ,$id_movimiento,$idproducto,$baseiva,$monto_iva,  $otros );
            }

            $sqlPillaro = "update agua.factura
                             set   estado_fe = 'SI'
                             where
                             id_factura   = ".$pillaro->sqlvalue_inyeccion( $fila["id_factura"] ,true) ;

            $pillaro->ejecutar($sqlPillaro);

    }

 
            
    }    
/*
*/
function K_comprobante($bd ){
    
    
    
    $sql = "SELECT   coalesce(factura,0) as secuencia
        	    FROM web_registro
        	    where ruc_registro = ".$bd->sqlvalue_inyeccion(trim( $_SESSION['ruc_registro'])  ,true);
    
    
    $parametros 			= $bd->ejecutar($sql);
    
    $secuencia 				= $bd->obtener_array($parametros);
    
    $contador = $secuencia['secuencia'] + 1;
    
    $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
    
    
    $sqlEdit = "UPDATE web_registro
    			   SET 	factura=".$bd->sqlvalue_inyeccion($contador, true)."
     			 WHERE ruc_registro=".$bd->sqlvalue_inyeccion(trim( $_SESSION['ruc_registro']), true);
    
    
    $bd->ejecutar($sqlEdit);
    
    
    return $input ;
}
/*
inserta detalle
*/
function detalle_movi( $bd ,$id_movimiento,$idproducto,$baseiva,$monto_iva,$tarifa_cero){
    
   
    $sesion  =  trim($_SESSION['email']);
    $ingreso = '0';
    $egreso  = '1';
 
    //----------------------------------------------------
    $total = $monto_iva + $tarifa_cero + $baseiva ;
    
    $costo = $tarifa_cero + $baseiva ;
    
    if ($monto_iva > 0 ){
        $tributo     = 'T';
    }else{
        $tributo     = 'I';
    }
   
 
    
    $ATabla = array(
        array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
        array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => 1,   filtro => 'N',   key => 'N'),
        array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
        array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
        array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
        array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
        array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
        array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $tributo,   filtro => 'N',   key => 'N'),
        array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
        array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
        array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'S',   valor => $baseiva,   filtro => 'N',   key => 'N'),
        array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
        
    );
    
    
    $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
    
  
}
?>