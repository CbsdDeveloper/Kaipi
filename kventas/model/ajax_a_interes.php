<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';    
require '../../kconfig/Obj.conf.php';  
 

 
$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    
    $fecha_emision = '2018-05-15';
    $fecha_obligacion = date("Y-m-d",strtotime($fecha_emision."+ 30 days")); 
    
    //$fecha_actual  =  date("Y-m-d"); 
    $anio_actual   =  date("Y");
    $mes_actual    =  date("m");
    
    $monto = 30;
    
    $fecha_temporal = explode('-', $fecha_obligacion);
    $anio_emision = $fecha_temporal[0];
    $mes_emision  = $fecha_temporal[1];
    
    
    if ( $anio_actual == $anio_emision ) {
        
        echo interes_mensual ($bd,$monto,$anio_emision,$mes_emision,$mes_actual );
         
    }
   
    if ( $anio_emision < $anio_actual ) {
     
        $total_anio = interes_anual ($bd,$monto,$anio_emision,$anio_actual );
        
        $total_mes = interes_mensual ($bd,$monto,$anio_actual,$mes_emision,$mes_actual );
        
        echo $total_anio + $total_mes;
    }
    
    
    //---------------------------//---------------------------//---------------------------
    //---------------------------//---------------------------//---------------------------
    function interes_mensual ($bd,$monto,$anio_emision,$mes_emision,$mes_actual ){
        
        $x_mensual = $bd->query_array('tesoreria.te_interes',
            'sum(monto) porcentaje_interes',
            'anio='.$bd->sqlvalue_inyeccion($anio_emision,true). ' and
         mes between '.$bd->sqlvalue_inyeccion($mes_emision,true). ' and '.$bd->sqlvalue_inyeccion($mes_actual,true)
            );
        
        $monto_interes = $monto  * ($x_mensual['porcentaje_interes']/100);
        
        return  round($monto_interes,2) ;
        
    }
    //---------------------------
    function interes_anual ($bd,$monto,$anio_emision,$anio_actual ){
        
        $anio_actual = $anio_actual - 1;
        
        $x_mensual = $bd->query_array('tesoreria.view_te_interes_anual',
            'sum(monto) porcentaje_interes',
            'anio between '.$bd->sqlvalue_inyeccion($anio_emision,true). ' and '.$bd->sqlvalue_inyeccion($anio_actual,true)
            );
        
           
        $monto_interes = $monto  * ($x_mensual['porcentaje_interes']/100);
        
        return  round($monto_interes,2) ;
        
    }
 /*
          $sql1 = 'SELECT ruc, tipo, nombre, fecha, arriendo, luz, monto
                    FROM rentas.temp01
                    order by tipo,ruc';  
     
 
        	$stmt1 = $bd->ejecutar($sql1);
         
            
        	$i = 1;
        	
            while ($x=$bd->obtener_fila($stmt1)){
  
                $ruc         =     $_SESSION['ruc_registro'];
                $sesion 	 =     trim('pvbt2009@hotmail.com');
                $hoy 	     =     date("Y-m-d");
                
                $idprov = trim($x["ruc"]);
                
                $AResultado = $bd->query_array('par_ciu',
                                               'id_par_ciu', 
                                               'idprov='.$bd->sqlvalue_inyeccion($idprov,true)
                );
                
                $sql = "update rentas.ren_arre_local 
                           set id_par_ciu= ".$bd->sqlvalue_inyeccion($AResultado["id_par_ciu"],true).'
                         where idprov='.$bd->sqlvalue_inyeccion($idprov,true);
                
                $bd->ejecutar($sql);
                
                
                $fecha1 =  $x["fecha"];
                
                $trozos = explode("/", $fecha1,3);
                
                 
                $dia1  =  str_pad($trozos[0],2,"0",STR_PAD_LEFT );
                $nmes  =  str_pad($trozos[1],2,"0",STR_PAD_LEFT );
                $anio1 =  $trozos[2]; 	
                
                $fecha =  $anio1.'-'.$nmes.'-'.$dia1;
                
                $detalle =  trim($x["tipo"]).' Periodo: '.$nmes.'-'.$anio1;  
                
                $documento = str_pad($i ,5,"0",STR_PAD_LEFT ).'-'.$anio1;
                
             
                
                $idperiodo = periodo($bd,$ruc,$fecha );
                
                 
                
                $ATabla = array(
                    array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor => $fecha,   filtro => 'N',   key => 'N'),
                    array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $ruc,   filtro => 'N',   key => 'N'),
                    array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => $detalle,   filtro => 'N',   key => 'N'),
                    array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $sesion ,   filtro => 'N',   key => 'N'),
                    array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $hoy,   filtro => 'N',   key => 'N'),
                    array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'digitado',   filtro => 'N',   key => 'N'),
                    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'F',   filtro => 'N',   key => 'N'),
                    array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor =>$idperiodo,   filtro => 'N',   key => 'N'),
                    array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => $documento,   filtro => 'N',   key => 'N'),
                    array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => $idprov,   filtro => 'N',   key => 'N'),
                    array( campo => 'cab_codigo',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => '9',   filtro => 'N',   key => 'N'),
                    array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor =>$fecha,   filtro => 'N',   key => 'N'),
                    array( campo => 'transaccion',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'N',   valor => 'arriendo',   filtro => 'N',   key => 'N')
                );
                
                $tabla 	  	  = 'inv_movimiento';
                
             
                $id_movimiento = $bd->_InsertSQL($tabla,$ATabla, '-' );
                
                
                $arriendo   =  $x["arriendo"];
                $luz        =  $x["luz"];
                $tipo       =  trim($x["tipo"]);
                
                if ( $arriendo <> '0' )
                {
                  
                    $lon = strlen($arriendo);
                    
                    if ($lon > 1 ) {
                        $monto_iva=20;
                        
                        if ( $tipo == 'COOPERATIVA DE TRANSPORTES') {
                            $idproducto = 567;
                        }else {
                            $idproducto = 571;
                        }
                     
                        
                        nuevo($bd,$ruc,$id_movimiento,$idproducto, $arriendo,$monto_iva,$sesion );
                    }
                }
                   
                if ( $luz <> '0' )
                {
                    $lon = strlen($luz);
                    if ($lon > 1 ) {
                        $monto_iva=0;
                        $idproducto = 568;
                        nuevo($bd,$ruc,$id_movimiento,$idproducto, $luz,$monto_iva,$sesion );
                    }
                }
            
                
                
                
                
                $i++;    
                echo $documento;
         
          	}
           
           	
           
            
 //---------------------------------------------------------
            function periodo($bd,$ruc,$fecha ){
                
                $anio = substr($fecha, 0, 4);
                $mes  = substr($fecha, 5, 2);
                
                $APeriodo = $bd->query_array('co_periodo',
                    'id_periodo, estado',
                    'registro='.$bd->sqlvalue_inyeccion($ruc,true). ' AND
											  mes = '.$bd->sqlvalue_inyeccion($mes,true). ' AND
											  anio ='.$bd->sqlvalue_inyeccion($anio,true)
                    );
                
                
 
                
                return $APeriodo['id_periodo'];
                
            }
 ////-------------------------------------------------------------------------------------------
            function nuevo($bd,$registro,$id_movimiento,$idproducto, $monto,$monto_iva,$sesion ){
                
                $ingreso = '0.00';;
                $egreso  = '1.00';;
                $IVA     = (1/12);
                
                      
                if ($monto_iva > 0 ){
                    
                    $baseiva     = round(($monto / 1.12),2);
                    $tarifa_cero = '0.00';
                    $monto_iva   = round($baseiva * $IVA,2);
                    $total1 =  $monto;
                    $tributo = 'I';
                    $venta =  $monto;
                    
                }else{
                    $monto_iva   = '0.00';
                    $tarifa_cero = $monto;
                    $baseiva = '0.00';
                    $total1 =  $monto;
                    $venta  =  $monto;
                    $tributo = 'T';
                }
                
                
                
                
                
                $ATabla1 = array(
                    array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
                    array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => 1,   filtro => 'N',   key => 'N'),
                    array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
                    array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $venta,   filtro => 'N',   key => 'N'),
                    array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total1,   filtro => 'N',   key => 'N'),
                    array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
                    array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
                    array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
                    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $tributo,   filtro => 'N',   key => 'N'),
                    array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
                    array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
                    array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'S',   valor => $baseiva,   filtro => 'N',   key => 'N'),
                    array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
                    
                );
                
                $bd->_InsertSQL('inv_movimiento_det',$ATabla1, '-' );
                            
                
            }
 */
  ?> 
								
 
 
 