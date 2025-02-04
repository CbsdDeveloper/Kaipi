<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 

 
$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        

    
    $contador 		    = 'B0213-2020';
    $array_codigo       = explode('-',$contador);
    $caracter           = $array_codigo[0];
    $entero             = substr($caracter, 1,5);
    
    echo intval($entero)  ;
    
    
    /*
    
        
    $str = "Hello";
    echo md5($str);
            $sql = "SELECT     id_movimiento, sesion,fecha,total
                    FROM public.view_inv_transaccion
                    where tipo = 'F' AND estado ='aprobado'";
            
            $stmt1 = $bd->ejecutar($sql);
            
            $i = 1;
            
            while ($x=$bd->obtener_fila($stmt1)){
                 
            
            $ATablaPago = array(
                array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $x["id_movimiento"],   filtro => 'N',   key => 'N'),
                array( campo => 'formapago',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => 'contado',   filtro => 'N',   key => 'N'),
                array( campo => 'tipopago',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => 'efectivo',   filtro => 'N',   key => 'N'),
                array( campo => 'monto',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => $x["total"],   filtro => 'N',   key => 'N'),
                array( campo => 'idbanco',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => '-2',   filtro => 'N',   key => 'N'),
                array( campo => 'cuenta',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '0000000000',   filtro => 'N',   key => 'N'),
                array( campo => 'fecha',   tipo => 'DATE',   id => '6',  add => 'S',   edit => 'S',   valor => $x["fecha"],   filtro => 'N',   key => 'N'),
                array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => $x["sesion"],   filtro => 'N',   key => 'N'),
                array( campo => 'idfacpago',   tipo => 'NUMBER',   id => '8',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S')
            );
           
 
            
            $bd->_InsertSQL('inv_fac_pago',$ATablaPago, '-' );
            
            $i ++ ;
            
            echo $i.' '.$x["id_movimiento"].' ->';
            
    
            }
    

    
    $sql1 = 'SELECT idprov
                    FROM rentas.view_ren_arren_local
                    order by idprov';  
    
    $stmt1 = $bd->ejecutar($sql1);
    
    $i = 1;
    while ($x=$bd->obtener_fila($stmt1)){
        
        $idprov = trim($x["idprov"]);
        
        $sql = "update inv_movimiento
                           set modulo= ".$bd->sqlvalue_inyeccion('arriendo',true).'
                         where idprov='.$bd->sqlvalue_inyeccion($idprov,true);
        
        $bd->ejecutar($sql);
        
        $i ++ ;
        
        echo $i.' '.$idprov.' ->';
        
    }
    
    */
    
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
           
           	*/
           
            
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
 
  ?> 
								
 
 
 