<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
    require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/
    
    
	$obj   = 	new objects;
	$bd	   = new Db ;
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    
    $saldos     = 	new saldo_contable(  $obj,  $bd);
     
 
    
    $idprov     =	$_GET["idprov"];
    $fecha_pago =	$_GET["ffecha2"];
    $idbancos   =	$_GET["idbancos"];
    $cmes       = 	$_GET["cmes"];
 
    
   
     $total_pago = _actualiza_pago($idprov,$bd);
       
     $result_cxcpago = '<b>Informacion ya generada'.'</b>';
     
     if ( $total_pago > 0 ){
         
         $id= agregar($idprov,
                  $total_pago,
                  $fecha_pago,
             $idbancos,$cmes,$bd,$saldos);
         
         $result_cxcpago = '<b>TRANSACCION REALIZADA CON EXITO Asiento : ' .$id.'</b>';
         
     
     }
     
  
     
    
     echo $result_cxcpago ;
 //--------------------------------------------------------------------------
 //--------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------
     function agregar( $idprov,
         $total_pago,
         $fecha_pago,
         $idbancos,$cmes,$bd,$saldos
        ){
            
            $ruc       =  $_SESSION['ruc_registro'];
            $sesion    =  $_SESSION['email'];
            
            $estado           =  'digitado';
            $total_apagar     =  $total_pago;
            $fecha		      =  $bd->fecha($fecha_pago);
            $hoy 	          =  $bd->hoy();
            $cuenta           = '-';
            
            $array_fecha   = explode("-", $fecha_pago);
            $mes           = $array_fecha[1];
            $anio          = $array_fecha[0];
            
            $id_asiento_ref =0;
            $secuencial     = '000-'.$anio;
            $cuenta='-';
            
            $cuenta_cobro ='';
            
            $detalle = 'Pago generado por debitos por pago impuestos,retenciones y obligaciones laborables '. 
                ' correspondientes al periodo  ('.$mes.'-'.$anio.')';
            
            //------------ seleccion de periodo
            $periodo_s = $bd->query_array('co_periodo',
                                        'id_periodo',
                                        'registro ='.$bd->sqlvalue_inyeccion($ruc ,true).' and
                                         anio ='.$bd->sqlvalue_inyeccion($anio ,true).' and
                                         mes='.$bd->sqlvalue_inyeccion($mes ,true)
                );
            $id_periodo = $periodo_s['id_periodo'];
            
            
            //------------------------------------------------------------
            $sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,modulo,
                						comprobante, estado, tipo, documento,idprov,cuentag,estado_pago,apagar, idmovimiento,
                                        id_asiento_ref,id_periodo)
										        VALUES (".$fecha.",".
										        $bd->sqlvalue_inyeccion($ruc, true).",".
										        $bd->sqlvalue_inyeccion($anio, true).",".
										        $bd->sqlvalue_inyeccion($mes, true).",".
										        $bd->sqlvalue_inyeccion( $detalle, true).",".
										        $bd->sqlvalue_inyeccion($sesion, true).",".
										        $hoy.",".
										        $bd->sqlvalue_inyeccion('contabilidad', true).",".
										        $bd->sqlvalue_inyeccion('-', true).",".
										        $bd->sqlvalue_inyeccion($estado, true).",".
										        $bd->sqlvalue_inyeccion('F', true).",".
										        $bd->sqlvalue_inyeccion(trim($secuencial), true).",".
										        $bd->sqlvalue_inyeccion(trim($idprov), true).",".
										        $bd->sqlvalue_inyeccion(trim($cuenta), true).",".
										        $bd->sqlvalue_inyeccion( 'S', true).",".
										        $bd->sqlvalue_inyeccion( $total_apagar, true).",".
										        $bd->sqlvalue_inyeccion( 0, true).",".
										        $bd->sqlvalue_inyeccion( $id_asiento_ref, true).",".
										        $bd->sqlvalue_inyeccion($id_periodo, true).")";
										        
			 $bd->ejecutar($sql);
										        
			 $idAsiento =  $bd->ultima_secuencia('co_asiento');
			 
	 
			 agregarDetalle( $idAsiento,trim($cuenta_cobro),$id_periodo,$mes,$anio,$total_apagar,$idprov,$bd,$id_asiento_ref);
			 
			 
			 $retencion_pago ='0999' ;
			 $cheque_pago = 'T'.$mes.'-'.$anio;
			 $tipo_pago ='transferencia';
			 
			 agregarBanco( $idAsiento,trim($idbancos),$id_periodo,$mes,$anio,$total_apagar,
			     $idprov,$bd,$id_asiento_ref,$retencion_pago,$cheque_pago, $tipo_pago,$secuencial,$detalle);
			 
			 	
			 
			 K_actualiza($idAsiento,$idprov,'S',$bd);
			 
			 $saldos->_aprobacion($idAsiento);
			 
			 
			 
			 return $idAsiento;
     }
     //--------------
     function K_actualiza($idAsiento,$idprov,$tipo,$bd){
         
 
         
         $sql = "SELECT id_asientod,id_asiento,cuenta
                FROM view_aux
                where idprov = ".$bd->sqlvalue_inyeccion($idprov,true)." and
                       estado = ".$bd->sqlvalue_inyeccion('aprobado',true)." and
                       pago = ".$bd->sqlvalue_inyeccion('N',true)." and
                       bandera = ". $bd->sqlvalue_inyeccion(trim('1') , true)."
                group by id_asientod,id_asiento,cuenta ";
         
         $stmt = $bd->ejecutar($sql);
         
         while ($x=$bd->obtener_fila($stmt)){
             
             $idAsientopago =  $x['id_asiento'];
             $id_asientod   =  $x['id_asientod'];
             
             $cuenta =  trim($x['cuenta']);
             
             $sqlA = "UPDATE co_asiento_aux
							    SET 	pago  =".$bd->sqlvalue_inyeccion('S', true).",
                                        bandera = ".$bd->sqlvalue_inyeccion(0, true).",
                                        id_asiento_ref = ".$bd->sqlvalue_inyeccion($idAsiento, true)." 
							      WHERE id_asiento   =".$bd->sqlvalue_inyeccion($idAsientopago, true). " and 
                                        idprov  =".$bd->sqlvalue_inyeccion($idprov, true). " and 
                                        cuenta  =".$bd->sqlvalue_inyeccion($cuenta, true). " and 
                                        id_asientod  =".$bd->sqlvalue_inyeccion($id_asientod, true) ;
                                        
             
             $bd->ejecutar($sqlA);
             
         }
         
         
         
         
     }	
     
     //------------------------------------------
     function agregarDetalle( $id,$cuenta,$id_periodo,$mes,$anio,$total1,$idprov,$bd,$id_asiento_ref){
         
         $ruc       =  $_SESSION['ruc_registro'];
         $sesion    =  $_SESSION['email'];
         $hoy 	          =  $bd->hoy();
         
         if ($total1 > 0) {
             
 
             $sql = "SELECT cuenta, partida, sum(haber) as haber
                FROM view_aux
                where idprov = ".$bd->sqlvalue_inyeccion($idprov,true)." and
                       estado = ".$bd->sqlvalue_inyeccion('aprobado',true)." and
                       pago = ".$bd->sqlvalue_inyeccion('N',true)." and
                       bandera = ". $bd->sqlvalue_inyeccion(trim('1') , true)."
                group by cuenta, partida ";    
             
             $stmt = $bd->ejecutar($sql);
             
             while ($x=$bd->obtener_fila($stmt)){
                 
    
                     $cuenta = trim($x['cuenta']) ;
                     $partida= trim($x['partida']);
                     
                     $item     = substr($partida,3,6);
                     $programa = substr($partida,0,3);
                     
                     $total1 = $x['haber'];
                     
                     $sql = "INSERT INTO co_asientod(
        								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
        								sesion, creacion, principal,partida,item,programa,registro)
        								VALUES (".
        								$bd->sqlvalue_inyeccion($id , true).",".
        								$bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
        								$bd->sqlvalue_inyeccion( 'S', true).",".
        								$bd->sqlvalue_inyeccion($total1, true).",".
        								$bd->sqlvalue_inyeccion(0, true).",".
        								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
        								$bd->sqlvalue_inyeccion( $anio, true).",".
        								$bd->sqlvalue_inyeccion( $mes, true).",".
        								$bd->sqlvalue_inyeccion($sesion , true).",".
        								$hoy.",".
        								$bd->sqlvalue_inyeccion( 'N', true).",".
        								$bd->sqlvalue_inyeccion( $partida, true).",".
        								$bd->sqlvalue_inyeccion( $item, true).",".
        								$bd->sqlvalue_inyeccion( $programa, true).",".
        								$bd->sqlvalue_inyeccion( $ruc, true).")";
        								
        								$bd->ejecutar($sql);
        			
        			  $id_asientod =  $bd->ultima_secuencia('co_asientod');
        								
        			  K_aux($id_asientod,$id,$idprov,$cuenta,$total1,0,$id_periodo,$anio,$mes,$bd,$id_asiento_ref);
			  
			  
             }
								
         }
     }
     //-------------------------------------------------------------
     function K_aux($id_asientod,$id_asiento,$idprov,$cuenta,$debe,$haber,$id_periodo,$anio,$mes,$bd,$id_asiento_ref){
      
         $ruc       =  $_SESSION['ruc_registro'];
         $sesion    =  $_SESSION['email'];
         $hoy 	          =  $bd->hoy();
         
         if (!empty($idprov)) {
             
             
             $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
		              									  anio, mes, sesion,tipo,pago, creacion,id_asiento_ref, registro) VALUES (".
		              									  $bd->sqlvalue_inyeccion($id_asientod  , true).",".
		              									  $bd->sqlvalue_inyeccion($id_asiento, true).",".
		              									  $bd->sqlvalue_inyeccion(trim($idprov) , true).",".
		              									  $bd->sqlvalue_inyeccion($cuenta , true).",".
		              									  $bd->sqlvalue_inyeccion($debe , true).",".
		              									  $bd->sqlvalue_inyeccion($haber , true).",".
		              									  $bd->sqlvalue_inyeccion(0 , true).",".
		              									  $bd->sqlvalue_inyeccion($id_periodo, true).",".
		              									  $bd->sqlvalue_inyeccion($anio, true).",".
		              									  $bd->sqlvalue_inyeccion($mes , true).",".
		              									  $bd->sqlvalue_inyeccion($sesion 	, true).",".
		              									  $bd->sqlvalue_inyeccion('C' 	, true).",".
		              									  $bd->sqlvalue_inyeccion('S' 	, true).",".
		              									  $hoy.",".
		              									  $bd->sqlvalue_inyeccion($id_asiento_ref 	, true).",".
		              									  $bd->sqlvalue_inyeccion( $ruc  , true).")";
		              									  
		              									  $bd->ejecutar($sql);
		              									  
         }
     }
 //------------------------------------------------------------------
     //------------------------------------------
     function agregarBanco( $id,$cuenta,$id_periodo,$mes,$anio,$total1,$idprov,$bd,
         $id_asiento_ref,$retencion_pago,$cheque_pago, $tipo_pago,$secuencial,$detalle){
         
         $ruc       =  $_SESSION['ruc_registro'];
         $sesion    =  $_SESSION['email'];
         $hoy 	          =  $bd->hoy();
         
         if ($total1 > 0) {
             
             $sql = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, principal,registro)
								VALUES (".
								$bd->sqlvalue_inyeccion($id , true).",".
								$bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
								$bd->sqlvalue_inyeccion( 'S', true).",".
								$bd->sqlvalue_inyeccion(0, true).",".
								$bd->sqlvalue_inyeccion($total1, true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion , true).",".
								$hoy.",".
								$bd->sqlvalue_inyeccion( 'N', true).",".
								$bd->sqlvalue_inyeccion( $ruc, true).")";
								
								$bd->ejecutar($sql);
								
								$id_asientod =  $bd->ultima_secuencia('co_asientod');
								
								K_auxbanco($id_asientod,$id,$idprov,$cuenta,0,$total1,$id_periodo,$anio,$mes,$bd,
								    $id_asiento_ref,$retencion_pago,$cheque_pago, $tipo_pago);
								
         }
         
         $secuencial          = $bd->_secuencias($anio, 'CE',8);
         
         _actualiza_aux($id,$idprov,$secuencial,$detalle,$bd);
       
     }
     //-------------------------------------------------------------
     function K_auxbanco($id_asientod,$id_asiento,$idprov,$cuenta,$debe,$haber,$id_periodo,$anio,$mes,$bd,
         $id_asiento_ref,$retencion_pago,$cheque_pago, $tipo_pago){
         
         $ruc       =  $_SESSION['ruc_registro'];
         $sesion    =  $_SESSION['email'];
         $hoy 	          =  $bd->hoy();
         
         if (!empty($idprov)) {
             
             
             $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
		              									  anio, mes, sesion,tipo,pago,retencion, cheque,creacion,id_asiento_ref, registro) VALUES (".
		              									  $bd->sqlvalue_inyeccion($id_asientod  , true).",".
		              									  $bd->sqlvalue_inyeccion($id_asiento, true).",".
		              									  $bd->sqlvalue_inyeccion(trim($idprov) , true).",".
		              									  $bd->sqlvalue_inyeccion($cuenta , true).",".
		              									  $bd->sqlvalue_inyeccion($debe , true).",".
		              									  $bd->sqlvalue_inyeccion($haber , true).",".
		              									  $bd->sqlvalue_inyeccion(0 , true).",".
		              									  $bd->sqlvalue_inyeccion($id_periodo, true).",".
		              									  $bd->sqlvalue_inyeccion($anio, true).",".
		              									  $bd->sqlvalue_inyeccion($mes , true).",".
		              									  $bd->sqlvalue_inyeccion($sesion 	, true).",".
		              									  $bd->sqlvalue_inyeccion($tipo_pago 	, true).",".
		              									  $bd->sqlvalue_inyeccion('S' 	, true).",".
		              									  $bd->sqlvalue_inyeccion($retencion_pago 	, true).",".
		              									  $bd->sqlvalue_inyeccion($cheque_pago 	, true).",".
		              									  $hoy.",".
		              									  $bd->sqlvalue_inyeccion($id_asiento_ref 	, true).",".
		              									  $bd->sqlvalue_inyeccion( $ruc  , true).")";
		              									  
		              									  $bd->ejecutar($sql);
		              									  
         }
     }
 //-------------------------
     function _actualiza_aux($id,$idprov,$comprobante,$detalle,$bd){
         
         
        
         
         $sql = "UPDATE co_asiento_aux
            							    SET 	detalle      =".$bd->sqlvalue_inyeccion(trim($detalle), true).",
                                                    comprobante  =".$bd->sqlvalue_inyeccion($comprobante, true)."
             							      WHERE id_asiento   =".$bd->sqlvalue_inyeccion($id, true). ' and
                                                    idprov       ='.$bd->sqlvalue_inyeccion(trim($idprov), true);
         
         $bd->ejecutar($sql);
         
         
     }
     
     //-----------------------------
     function _actualiza_pago($idprov,$bd){
         
           
 
         $sql = "SELECT   sum(haber)  as haber
                FROM view_aux
                where idprov = ". $bd->sqlvalue_inyeccion($idprov , true).' and
                       estado = '. $bd->sqlvalue_inyeccion('aprobado' , true).' and
                       pago= '. $bd->sqlvalue_inyeccion('N' , true).' and
                       bandera= '. $bd->sqlvalue_inyeccion('1' , true);
   
         
         $resultado1 = $bd->ejecutar($sql);
         $datos_sql   = $bd->obtener_array( $resultado1);
         $total           = $datos_sql['haber'] ;
         
         return $total;
         
     }
?>
 
  