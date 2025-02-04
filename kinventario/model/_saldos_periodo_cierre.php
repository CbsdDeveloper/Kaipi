 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
   
    $cbodega               =     $_GET["idbodega"];
    $anio  			       =     $_GET["anio"];
 
 
    
    $anio_anterior = $anio -  1;
    
    $fecha1 = $anio_anterior.'-01-01';
    
    $fecha2 = $anio_anterior.'-12-31';
 
    $fecha3 = $anio  .'-01-01';
    
    $delete = 'delete from inv_saldos_kar where idbodega = '.$bd->sqlvalue_inyeccion($cbodega,true);
    
    $bd->ejecutar($delete);
    
    
    $sql_det = 'SELECT idproducto,count(*) as nn,producto
                 from view_inv_movimiento_kar 
                where ( fecha between '."'".$fecha1."'"." and "."'".$fecha2."'".')  and
                      idbodega = '.$bd->sqlvalue_inyeccion($cbodega,true).'  
                group by idproducto,producto order by idproducto';
        
 
    
    $stmt2 = $bd->ejecutar($sql_det);
    
    $i = 1;
    
    while ($x=$bd->obtener_fila($stmt2)){
        
        $contador   = $x['nn'];
        
        $idproducto = $x['idproducto'];
         
        if ( $contador >= 1){
            
            costo_promedio($bd,$idproducto,$fecha2, $anio_anterior ,'01',$cbodega);
             
            $i ++;
            
        }
    }
    
     
    
    
    $Avalida= $bd->query_array('view_inv_movimiento','count(*) as nn',
        'anio='.$bd->sqlvalue_inyeccion($anio  ,true) ." and 
        trim(transaccion) ='carga inicial' and 
        idbodega= ".$bd->sqlvalue_inyeccion($cbodega,true) 
        );
    
    if ( $Avalida['nn'] > 0 ){
        
        echo  'MOVIMIENTO DE CARGA INICIAL YA GENERADO.... REVISE SU INFORMACION';
        
    }else{
        
 
            $id =  agrega_movimiento($bd,$fecha3,$anio,$cbodega);
            
            ///------------------------------------------------------------------
            $sqlk ="SELECT  *
                FROM  inv_saldos_kar
                WHERE idbodega= ".$bd->sqlvalue_inyeccion($cbodega,true) ;
            
            
            $stmtk = $bd->ejecutar($sqlk);
            
            while ($y=$bd->obtener_fila($stmtk)){
                 nuevo($id,$y, $bd  );
            }
            
 
            echo   'TRANSACCION GENERADA CON EXITO...'.$id;
    
    }
 //-----------------
    function costo_saldo($bd,$idproducto){
        
        $AResultado = $bd->query_array('web_producto','costo', 
            'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true));
        
        return $AResultado['costo'];
        
    }
    
    //-----------------
    function costo_promedio($bd,$idproducto,$fecha2,$anio,$mes,$cbodega){
        
        
        $fecha1 = $anio.'-01-01';
        
        $fecha2 = $anio.'-12-31';
        
        $sql_det ="SELECT  fecha, tipo, costo,cantidad,total,ingreso,egreso,(cantidad * costo) as total_variable,
                             id_movimiento, detalle,razon,comprobante,producto
        FROM  view_mov_aprobado
        WHERE ( fecha between "."'".$fecha1."'"." and "."'".$fecha2."'".") and 
              idproducto= ".$bd->sqlvalue_inyeccion($idproducto,true).' 
        order by fecha asc,ingreso desc, tipo asc';
   
         
        $stmt21 = $bd->ejecutar($sql_det);
        
        $i = 1;
        
        $total_saldo    = 0;
        $total_cantidad = 0;
        $tota_promedio  = 0;
        
        $total_ingreso = 0;
        $total_egreso  = 0;
         
    
        $cantidad_ingreso = 0;
        $cantidad_egreso  = 0;
        
        
        $total_egreso   = 0;
        
    //    $tota_lifo1  = 0;
        
        while ($y=$bd->obtener_fila($stmt21)){
            
             $tipo     = $y['tipo'];
             $cantidad = $y['cantidad'];
           
            //--- sin afectar al iva
            // $total    = $y['total_variable'];
            //--- con afectar al iva
            $total    = $y['total'];
            
            if ( $i == 1) {
                
                if ( $tipo == 'I') {
                    $total_cantidad = $total_cantidad + $cantidad;
                    $total_saldo    = $total_saldo + $total;
                    
                    $tota_promedio     = $total_saldo / $total_cantidad;
                    $cantidad_ingreso  = $cantidad_ingreso  + $cantidad ;
                    $total_ingreso     = $total_ingreso + $total;
                        
                } else {
                    $total_egreso   = $total_egreso + $total;
                    $total_cantidad = $total_cantidad - $cantidad;
                    $total_saldo    = $total_saldo - $total;
                    if ( $total_cantidad == 0 ){
                        $tota_promedio = $tota_promedio;
                    }else{
                        $tota_promedio  = round($total_saldo / $total_cantidad,6);
                    }
                    $cantidad_egreso = $cantidad_egreso + $cantidad;
                }
             }else{
                
                if ( $tipo == 'I') {
                    
                    $total_cantidad    = $total_cantidad + $cantidad;
                    $cantidad_ingreso  = $cantidad_ingreso  + $cantidad ;
                    
                    $total_saldo    = $total_saldo + $total;
                    
                    $tota_promedio  = round($total_saldo,6) / round($total_cantidad,6);
                     //$costo_ingreso  = $costo;
                    
                    $total_ingreso     = $total_ingreso + $total;
                    
                 }else {
                    
                    $total_egreso   = $total_egreso + $total;
                    $total_cantidad = $total_cantidad - $cantidad;
                    $total_saldo    = $total_saldo - $total;
                   
                    
                    if ( $total_cantidad == 0 ){
                        $tota_promedio = $tota_promedio;
                    }else{
                        $tota_promedio  = round($total_saldo / $total_cantidad,6);
                    }
                    // $costo_ingreso  = '0.00';
                    // $total_ingreso  = '0.00';
                  //  $saldo_egreso  = $saldo_egreso  +  $total_egreso;
                    
                    $cantidad_egreso = $cantidad_egreso + $cantidad;
                    
                  
                }
                
            }
            
           
            $i++;
        }
 
     //   $total_saldo = $total_ingreso - $total_egreso;
        
        $InsertQuery = array(
            array( campo => 'idbodega',   valor =>$cbodega),
            array( campo => 'idproducto',   valor =>$idproducto),
            array( campo => 'entrada',   valor => $cantidad_ingreso),
            array( campo => 'salida',   valor => $cantidad_egreso),
            array( campo => 'saldo',   valor => $total_cantidad),
            array( campo => 'ventrada',   valor => $total_ingreso),
            array( campo => 'vsalida', valor => $total_egreso),
            array( campo => 'vsaldo',   valor => $total_saldo),
            array( campo => 'anio',   valor =>$anio),
            array( campo => 'sesion',   valor => trim(  $_SESSION['email']))
        );
        
        
       $bd->pideSq(0);
        
       $bd->JqueryInsertSQL('inv_saldos_kar',$InsertQuery);
        
       ///--------------------------------------------------------------------
 
        
    }
    //-----------
    function agrega_movimiento($bd,$fecha1,$anio,$idbodega){
        
        $ruc       =     trim($_SESSION['ruc_registro']);
        
        $sesion 	 =     trim($_SESSION['email']);
        
        $hoy 	     =     date("Y-m-d");   
        
        $anio1       = $anio ;
        
        $detalle  = 'Registro de carga inicial al inicio del periodo '.$anio1       ;
        
         
        $ATabla = array(
            array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'S',   valor =>$fecha1,   filtro => 'N',   key => 'N'),
            array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $ruc,   filtro => 'N',   key => 'N'),
            array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor =>$detalle,   filtro => 'N',   key => 'N'),
            array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $sesion ,   filtro => 'N',   key => 'N'),
            array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $hoy,   filtro => 'N',   key => 'N'),
            array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '000-'.$anio1       ,   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'aprobado',   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'I',   filtro => 'N',   key => 'N'),
            array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '000-'.$anio1  ,   filtro => 'N',   key => 'N'),
            array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => $ruc,   filtro => 'N',   key => 'N'),
            array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'transaccion',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => 'carga inicial',   filtro => 'N',   key => 'N'),
            array( campo => 'idbodega',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => $idbodega,   filtro => 'N',   key => 'N'),
            array( campo => 'id_departamento',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => '1',   filtro => 'N',   key => 'N'),
            array( campo => 'autorizacion',   tipo => 'VARCHAR2',   id => '17',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'id_tramite',   tipo => 'NUMBER',   id => '18',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
            array( campo => 'fechaa',   tipo => 'DATE',   id => '19',  add => 'S',   edit => 'S',   valor =>$fecha1,   filtro => 'N',   key => 'N'),
        );
        
         
        $tabla 	  	  = 'inv_movimiento';
          
        $id = $bd->_InsertSQL($tabla,$ATabla, 'id_inv_movimiento' );
        
        return  $id;
        
    }
    
  //--------------------
    function nuevo($id_movimiento,$y, $bd  ){
        
        //---------------------------------------------------
         
        //$IVADesglose = 1 + $IVA;
        $sesion 	       =    $_SESSION['email'];
        
        $idproducto        =   $y['idproducto'];
        //----------------------------------------------------
        
     
        
        //----------------------------------------------------
        $saldo    = $y['saldo'];
        $ingreso  = $y['saldo'];
        $egreso   = 0;
         
        //----------------------------------------------------
        
            $monto_iva   = 0;
            $tarifa_cero = $y['vsaldo'];
            $baseiva = 0;
            $total   = $y['vsaldo'];
            
            
            if ( $saldo > 0 ){
                    
                    $costo   = $total/$saldo  ;
                    $costo   = round($costo,4);
                 
                $ATabla = array(
                    array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
                    array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $saldo,   filtro => 'N',   key => 'N'),
                    array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
                    array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
                    array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
                    array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
                    array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
                    array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
                    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => 'T',   filtro => 'N',   key => 'N'),
                    array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
                    array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
                    array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => $baseiva,   filtro => 'N',   key => 'N'),
                    array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N'),
                    array( campo => 'descuento',   tipo => 'NUMBER',   id => '14',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
                    array( campo => 'pdescuento',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N')
                );
                
              
                   $bd->_InsertSQL('inv_movimiento_det',$ATabla, 'id_inv_movimiento_det' );
                    
        }
           
    }
    
?>
 
  