<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
    require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/
    
    
	$obj   = 	new objects;
	$bd	   = new Db ;
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
    
    $saldos     = 	new saldo_contable(  $obj,  $bd);
     
    $idprov=	$_GET["idprov"];
    $cuenta_cobro=	$_GET["cuenta_cobro"];
    $cobro_total=	$_GET["cobro_total"];
    $cobro_pago=	$_GET["cobro_pago"];
    
    $retencion_pago=	$_GET["retencion_pago"];
    $cheque_pago=	$_GET["cheque_pago"];
    $tipo_pago=	$_GET["tipo_pago"];
    $fecha_pago=	$_GET["fecha_pago"];
    $idbancos=	$_GET["idbancos"];
    $id_asiento = $_GET["id_asiento"] ;
     $secuencial = $_GET["secuencial"] ;
    
   
     $saldo = _actualiza_pago($id_asiento,$idprov,$cuenta_cobro,$bd);
       
 
     if ($saldo == 0 )  
     {
         K_actualiza($id_asiento,'S',$bd) ;
         
         $result_cxcpago = '<b>Factura ya pagada'.'</b>';
         
     }
      else {
          
            if  ($cobro_pago > $cobro_total ) {
               
            }else{
                
                if (!empty($idbancos)){
                    if (!empty($cheque_pago)){
                        if (!empty($tipo_pago)){
                            if (!empty($retencion_pago)){
                                if (!empty($fecha_pago)){
                                    //---------------------------------------------
                                    agregar($idprov,$cuenta_cobro,
                                            $cobro_total,$cobro_pago,
                                            $retencion_pago,$cheque_pago,
                                            $tipo_pago,$fecha_pago,
                                             $idbancos,$id_asiento,$secuencial,$bd,$saldos);
                                    
                                    $result_cxcpago = '<b>TRANSACCION REALIZADA CON EXITO' .$saldo.'</b>';
                                    
                                    $saldo1 = _actualiza_pago($id_asiento,$idprov,$cuenta_cobro,$bd);
                                    
                                    if ($saldo1 == 0 )
                                    {
                                        K_actualiza($id_asiento,'S',$bd) ;
                                    }
                                    
                                    
                                    //---------------------------------------------
                                }else {
                                    $result_cxcpago = '<b>Ingrese Retencion/Fecha de pago, para realizar la transaccion'.'</b>';
                                }
                            }else {
                                $result_cxcpago = '<b>Ingrese Retencion/Forma de pago, para realizar la transaccion'.'</b>';
                            }
                        }else {
                            $result_cxcpago = '<b>Ingrese cheque/Forma de pago, para realizar la transaccion'.'</b>';
                        }
                    }else {
                        $result_cxcpago = '<b>Ingrese cheque/Forma de pago, para realizar la transaccion'.'</b>';
                    }
                }else {
                    $result_cxcpago = '<b>Seleccione la cuenta de bancos, para realizar la transaccion'.'</b>';
                }
               
             }
      }
     
    
     echo $result_cxcpago ;
 //--------------------------------------------------------------------------
 //--------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------
    function agregar( $idprov,$cuenta_cobro,
        $cobro_total,$cobro_pago,
        $retencion_pago,$cheque_pago,
        $tipo_pago,$fecha_pago,
        $idbancos,$id_asiento_ref,$secuencial,$bd,$saldos
        ){
            
            $ruc       =  $_SESSION['ruc_registro'];
            $sesion    =  $_SESSION['email'];
            
            $estado           =  'digitado';
            $total_apagar     =  $cobro_pago;
            $fecha		      =  $bd->fecha($fecha_pago);
            $hoy 	          =  $bd->hoy();
            $cuenta           = '-';
            
            $array_fecha   = explode("-", $fecha_pago);
            $mes           = $array_fecha[1];
            $anio          = $array_fecha[0];
            
       //     $id_asiento_ref
            
            
            $detalle = 'Pago efectuado a la factura nro. '.$secuencial. 
                       ' con el documento nro. '.$cheque_pago. ' nro de asiento de referencia ('.$id_asiento_ref.')';
            
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
										        $bd->sqlvalue_inyeccion('bancos', true).",".
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
			 
			 _actualiza_aux($id,$idprov,$secuencial,$detalle,$bd);
										        
			 agregarDetalle( $idAsiento,trim($cuenta_cobro),$id_periodo,$mes,$anio,$total_apagar,$idprov,$bd,$id_asiento_ref);
			 
			 agregarBanco( $idAsiento,trim($idbancos),$id_periodo,$mes,$anio,$total_apagar,
			     $idprov,$bd,$id_asiento_ref,$retencion_pago,$cheque_pago, $tipo_pago,$secuencial,$detalle);
			 
			 
			 if ($cobro_pago == $cobro_total){
			     K_actualiza($id_asiento_ref,'S',$bd);
			 }
			 else {
			     K_actualiza($id_asiento_ref,'N',$bd);
			 }
									
			 
			
			 
			 $saldos->_aprobacion($idAsiento);
			 
     }
     //--------------
     function K_actualiza($idAsiento,$tipo,$bd){
         
         
         $sql = "UPDATE co_asiento
							    SET 	estado_pago  =".$bd->sqlvalue_inyeccion($tipo, true)."
							      WHERE id_asiento   =".$bd->sqlvalue_inyeccion($idAsiento, true);
         
         $bd->ejecutar($sql);
         
         
     }	
     
     //------------------------------------------
     function agregarDetalle( $id,$cuenta,$id_periodo,$mes,$anio,$total1,$idprov,$bd,$id_asiento_ref){
         
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
								$bd->sqlvalue_inyeccion( 'S', true).",".
								$bd->sqlvalue_inyeccion( $ruc, true).")";
								
								$bd->ejecutar($sql);
			
			  $id_asientod =  $bd->ultima_secuencia('co_asientod');
								
			  K_aux($id_asientod,$id,$idprov,$cuenta,0,$total1,$id_periodo,$anio,$mes,$bd,$id_asiento_ref);
								
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
								$bd->sqlvalue_inyeccion($total1, true).",".
								$bd->sqlvalue_inyeccion(0, true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion , true).",".
								$hoy.",".
								$bd->sqlvalue_inyeccion( 'N', true).",".
								$bd->sqlvalue_inyeccion( $ruc, true).")";
								
								$bd->ejecutar($sql);
								
								$id_asientod =  $bd->ultima_secuencia('co_asientod');
								
								K_auxbanco($id_asientod,$id,$idprov,$cuenta,$total1,0,$id_periodo,$anio,$mes,$bd,
								    $id_asiento_ref,$retencion_pago,$cheque_pago, $tipo_pago);
								
         }
         
         
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
     function _actualiza_pago($idasiento,$idprov,$cuenta,$bd){
         
           
 
         $saldos = $bd->query_array(
              'view_aux',
              'sum(debe) as debe,sum(haber) as haber',
              'id_asiento ='. $bd->sqlvalue_inyeccion($idasiento , true).' and
               idprov = '. $bd->sqlvalue_inyeccion($idprov , true).' and
               estado = '. $bd->sqlvalue_inyeccion('aprobado' , true).' and
               cuenta='. $bd->sqlvalue_inyeccion(trim($cuenta) , true)
             );
         
         $saldosAux = $bd->query_array(
             'view_aux',
             'sum(debe) as debe,sum(haber) as haber',
             'id_asiento_ref ='. $bd->sqlvalue_inyeccion($idasiento , true).' and
               idprov = '. $bd->sqlvalue_inyeccion($idprov , true).' and
               estado = '. $bd->sqlvalue_inyeccion('aprobado' , true).' and
               cuenta='. $bd->sqlvalue_inyeccion(trim($cuenta) , true)
             );
         
         
         $saldo1       =  $saldos['debe'] - $saldos['haber'];
         $saldo2       =   $saldosAux['debe'] - $saldosAux['haber']; 
         
         $saldo       =   $saldo1 + $saldo2;
 
         
 
         
         return $saldo;
         
     }
?>
 
  