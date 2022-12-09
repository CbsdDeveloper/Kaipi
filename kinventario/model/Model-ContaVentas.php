<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $ATabla;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
		$this->ATabla = array(
		    array( campo => 'id_ventas',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
		    array( campo => 'id_asiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'tpidcliente',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'idcliente',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'numerocomprobantes',tipo => 'NUMBER',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'basenograiva',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'baseimponible',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'baseimpgrav',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'montoiva',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'valorretiva',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'valorretrenta',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'secuencial',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'codestab',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '001', key => 'N'),
		    array( campo => 'fechaemision',tipo => 'DATE',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'registro',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => $this->ruc , key => 'N'),
		    array( campo => 'valorretbienes',tipo => 'NUMBER',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'valorretservicios',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'anexo',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '1', key => 'N'),
		    array( campo => 'tipoemision',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => 'F', key => 'N'),
		    array( campo => 'formapago',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '01', key => 'N'),
		    array( campo => 'montoice',tipo => 'NUMBER',id => '21',add => 'S', edit => 'S', valor => '0', key => 'N')
		);
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2,$idbancos ,$tipofacturaf){
		
	    
	    $this->_Verifica_facturas();
	    $this->_Verifica_suma_facturas();
	    $this->_Verifica_suma_facturas_Total( ) ;
	    
	    
	    $array_fecha   = explode("-", $f1);
	    $mes           = $array_fecha[1];
	    $anio          = $array_fecha[0];
	    
	    //------------ seleccion de periodo
	    $periodo_s = $this->bd->query_array('co_periodo',
	        'id_periodo',
	        'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
             anio ='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
             mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
	        );
	    
	    $id_periodo = $periodo_s['id_periodo'];
	    
	    //------------------------------------------------------------------
	    $ACuentaIVA = $this->bd->query_array( 'co_catalogo',
	        'cuenta',
	        'secuencia='.$this->bd->sqlvalue_inyeccion(123,true)
	        );
	    
	    $acuenta_iva = $ACuentaIVA['cuenta'];
	 
	    //------------------------------------------------------------------
	    $ACuentaCxC = $this->bd->query_array('co_plan_ctas',
	        'cuenta',
	        'univel='.$this->bd->sqlvalue_inyeccion('S',true).' and
             tipo_cuenta ='.$this->bd->sqlvalue_inyeccion('C',true).' and
             registro ='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
	        );
	    
	    $acuentacxc = $ACuentaCxC['cuenta'];
	    
	    $ContabilizadoVentas = 'Cuenta IVA '.$acuenta_iva. ' Cuenta cXc '.$acuentacxc.'<br>';
	    
	    $bandera1=0;
	    $bandera2=0;
	    
	    if (!empty($acuenta_iva)){
	        $bandera1 = 1;
	    }
	    if (!empty($acuentacxc)){
	        $bandera2 = 1;
	    }
	    
	    $valida = $bandera2 + $bandera1 ;
  	    //----------------------------------------------------------------
 
	    if ( $valida >= 2){
	        
	        $Ccredito          = $this->credito($acuenta_iva,$acuentacxc,$id_periodo,$f1,$f2,$idbancos ,$tipofacturaf,$mes,$anio);
	        
	        $Cpago_consumidor  = $this->pago_consumidor($acuenta_iva,$acuentacxc,$id_periodo,$f1,$f2,$idbancos ,$tipofacturaf,$mes,$anio);
	        
	        $ContabilizadoVentas .= $Ccredito.$Cpago_consumidor;
	    
	        echo $ContabilizadoVentas;
	    
	    }
 	    
	}
 //---------------------------------------------------------------------------------------------
	function agregar( $id_movimiento,
	                   $id_periodo,
	                   $fecha1,$cuenta,
	                   $secuencial,
	                   $idprov,
	                   $mes,
	                   $anio,	    
                	   $baseimpgrav , 
                	   $tarifacero ,
                 	   $montoiva  ,
                	   $montoice ,
	                   $detalle,
	                   $acuenta_iva,
	                   $acuentacxc,$idbancos,$compro,$f1,$f2,$espago
	                   ){
	    
        $estado           =  'digitado';
        
        $total_apagar     =  $baseimpgrav + $tarifacero  + $montoiva;
        
        $fecha		  = $this->bd->fecha($fecha1);
        
        
	    //------------------------------------------------------------
	    $sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,modulo,
                						comprobante, estado, tipo, documento,idprov,cuentag,estado_pago,apagar, idmovimiento,
                                        id_periodo)
										        VALUES (".$fecha.",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion($mes, true).",".
										        $this->bd->sqlvalue_inyeccion( $detalle, true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $this->hoy.",".
										        $this->bd->sqlvalue_inyeccion('cxcobrar', true).",".
										        $this->bd->sqlvalue_inyeccion('-', true).",".
										        $this->bd->sqlvalue_inyeccion($estado, true).",".
										        $this->bd->sqlvalue_inyeccion('F', true).",".
										        $this->bd->sqlvalue_inyeccion(trim($secuencial), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($idprov), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($cuenta), true).",".
										        $this->bd->sqlvalue_inyeccion( 'N', true).",".
										        $this->bd->sqlvalue_inyeccion( $total_apagar, true).",".
										        $this->bd->sqlvalue_inyeccion( $id_movimiento, true).",".
 										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
 										        
										        $this->bd->ejecutar($sql);
										        
 										        $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
 										        
 		$this->agregarDetalle( $idAsiento,trim($cuenta),$id_periodo,$mes,$anio,$baseimpgrav,$tarifacero);
 										        
 		$this->K_iva($idAsiento,$mes,$anio,$id_periodo,$montoiva,$acuenta_iva);
 	 										        
 	    $this->K_cliente($idAsiento,$mes,$anio,$id_periodo,$total_apagar,$acuentacxc,trim($idprov));
			
        $this->AnexosTransacional($idAsiento,trim($idprov),$baseimpgrav,$tarifacero,$montoiva,$montoice,$secuencial,$fecha1,$compro);
 		
  
        if ($espago == 2){
            $this->K_clienteCierre($idAsiento,$mes,$anio,$id_periodo,$total_apagar,$acuentacxc,trim($idprov));
            $this->K_Banco($idAsiento,$mes,$anio,$id_periodo,$total_apagar,$idbancos);
            
        }
 
 		    
 		//----------
 		$this->saldos->_aprobacion($idAsiento);
 									        
 		$this->K_actualizaInventario($idAsiento,$id_movimiento,$f1,$f2,trim($idprov));  
	}
//------------------------------------------
	function agregarDetalle( $id,$cuenta,$id_periodo,$mes,$anio,$baseimpgrav,$tarifacero){
  
	    $total1 = ($baseimpgrav + $tarifacero )  ;
	    
	    if ($total1 > 0) {
	         
	        $sql = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, principal,registro)
								VALUES (".
								$this->bd->sqlvalue_inyeccion($id , true).",".
								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
								$this->bd->sqlvalue_inyeccion( 'N', true).",".
								$this->bd->sqlvalue_inyeccion(0, true).",".
								$this->bd->sqlvalue_inyeccion($total1, true).",".
								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$this->bd->sqlvalue_inyeccion( $anio, true).",".
								$this->bd->sqlvalue_inyeccion( $mes, true).",".
								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
								$this->hoy.",".
								$this->bd->sqlvalue_inyeccion( 'S', true).",".
								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
	  
	        $this->bd->ejecutar($sql);
	    
	    }
 	}
 //-------------------------------------------------------------
 	function K_iva($id,$mes,$anio,$periodo_s,$iva_total,$acuentag){
 	    

 	    if ($iva_total > 0) {
 	        
 	        
            $sql = "INSERT INTO co_asientod(
            						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
            						sesion, creacion, registro)
            						VALUES (".
            						$this->bd->sqlvalue_inyeccion($id, true).",".
            						$this->bd->sqlvalue_inyeccion($mes, true).",".
            						$this->bd->sqlvalue_inyeccion($anio, true).",".
            						$this->bd->sqlvalue_inyeccion($periodo_s, true).",".
            						$this->bd->sqlvalue_inyeccion( $acuentag, true).",".
            						$this->bd->sqlvalue_inyeccion( 'S', true).",".
            						$this->bd->sqlvalue_inyeccion( 0, true).",".
            						$this->bd->sqlvalue_inyeccion($iva_total, true).",".
            						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
            						$this->hoy.",".
            						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
            						
            						$this->bd->ejecutar($sql);
            						
           $id_asientod =  $this->bd->ultima_secuencia('co_asientod');
           
           $idprov = $this->K_aux_prov($acuentag);
           
           $this->K_aux($id_asientod,$id,$idprov,$acuentag,0,$iva_total,$periodo_s,$anio,$mes);
           
           
 	    }
}
//-------------------------------------------------------------
function K_aux($id_asientod,$id_asiento,$idprov,$cuenta,$debe,$haber,$id_periodo,$anio,$mes){
    
    
    if (!empty($idprov)) {
        
        $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
		              									  anio, mes, sesion, creacion, registro) VALUES (".
		              									  $this->bd->sqlvalue_inyeccion($id_asientod  , true).",".
		              									  $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
		              									  $this->bd->sqlvalue_inyeccion(trim($idprov) , true).",".
		              									  $this->bd->sqlvalue_inyeccion($cuenta , true).",".
		              									  $this->bd->sqlvalue_inyeccion($debe , true).",".
		              									  $this->bd->sqlvalue_inyeccion($haber , true).",".
		              									  $this->bd->sqlvalue_inyeccion(0 , true).",".
		              									  $this->bd->sqlvalue_inyeccion($id_periodo, true).",".
		              									  $this->bd->sqlvalue_inyeccion($anio, true).",".
		              									  $this->bd->sqlvalue_inyeccion($mes , true).",".
		              									  $this->bd->sqlvalue_inyeccion($this->sesion 	, true).",".
		              									  $this->hoy.",".
		              									  $this->bd->sqlvalue_inyeccion( $this->ruc  , true).")";
        						
        						$this->bd->ejecutar($sql);
        						
    }
}
 //------------------------------------
function K_cliente($idAsiento,$mes,$anio,$id_periodo,$apagar,$acuentag,$idprov){
 	    
 
    if ($apagar > 0 ){
 	        
 	        $sql = "INSERT INTO co_asientod(
						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
						sesion, creacion, registro)
						VALUES (".
						$this->bd->sqlvalue_inyeccion($idAsiento, true).",".
						$this->bd->sqlvalue_inyeccion($mes, true).",".
						$this->bd->sqlvalue_inyeccion($anio, true).",".
						$this->bd->sqlvalue_inyeccion($id_periodo, true).",".
						$this->bd->sqlvalue_inyeccion( $acuentag, true).",".
						$this->bd->sqlvalue_inyeccion( 'S', true).",".
						$this->bd->sqlvalue_inyeccion( $apagar, true).",".
						$this->bd->sqlvalue_inyeccion( 0, true).",".
						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
						$this->hoy.",".
						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
						
				 
						 $this->bd->ejecutar($sql);
						 $id_asientod =  $this->bd->ultima_secuencia('co_asientod');
						 $this->K_aux($id_asientod,$idAsiento,$idprov,$acuentag,$apagar,0,$id_periodo,$anio,$mes);
         }
 	}	
 	//--------------------
 	function K_clienteCierre($idAsiento,$mes,$anio,$id_periodo,$apagar,$acuentag,$idprov){
 	    
 	    
 	    if ($apagar > 0 ){
 	        
 	    
 	    $sql = "INSERT INTO co_asientod(
						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
						sesion, creacion, registro)
						VALUES (".
						$this->bd->sqlvalue_inyeccion($idAsiento, true).",".
						$this->bd->sqlvalue_inyeccion($mes, true).",".
						$this->bd->sqlvalue_inyeccion($anio, true).",".
						$this->bd->sqlvalue_inyeccion($id_periodo, true).",".
						$this->bd->sqlvalue_inyeccion( $acuentag, true).",".
						$this->bd->sqlvalue_inyeccion( 'S', true).",".
						$this->bd->sqlvalue_inyeccion( 0, true).",".
						$this->bd->sqlvalue_inyeccion( $apagar, true).",".
						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
						$this->hoy.",".
						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
						
						
						$this->bd->ejecutar($sql);
						$id_asientod =  $this->bd->ultima_secuencia('co_asientod');
						$this->K_aux($id_asientod,$idAsiento,$idprov,$acuentag,0,$apagar,$id_periodo,$anio,$mes);
						
						$sql = "UPDATE co_asiento_aux
							    SET 	pago  =".$this->bd->sqlvalue_inyeccion('S', true)."
							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idAsiento, true).' and
                                        idprov ='.$this->bd->sqlvalue_inyeccion($idprov, true);
						
						
						$this->bd->ejecutar($sql);
						
 	    }
						
 	}
 	//------------------------------------
 	function K_Banco($idAsiento,$mes,$anio,$id_periodo,$apagar,$acuentag){
  	    
 	    if ($apagar > 0 ){
 	        
         	    $sql = "INSERT INTO co_asientod(
        						id_asiento, mes,anio,id_periodo,cuenta, aux,debe, haber,
        						sesion, creacion, registro)
        						VALUES (".
        						$this->bd->sqlvalue_inyeccion($idAsiento, true).",".
        						$this->bd->sqlvalue_inyeccion($mes, true).",".
        						$this->bd->sqlvalue_inyeccion($anio, true).",".
        						$this->bd->sqlvalue_inyeccion($id_periodo, true).",".
        						$this->bd->sqlvalue_inyeccion( $acuentag, true).",".
        						$this->bd->sqlvalue_inyeccion( 'S', true).",".
        						$this->bd->sqlvalue_inyeccion( $apagar, true).",".
        						$this->bd->sqlvalue_inyeccion( 0, true).",".
        						$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
        						$this->hoy.",".
        						$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
        						
        						
        						$this->bd->ejecutar($sql);
         		
        						$id_asientod =  $this->bd->ultima_secuencia('co_asientod');
        						$idprov = $this->K_aux_prov($acuentag);
        						$this->K_aux($id_asientod,$idAsiento,$idprov,$acuentag,$apagar,0,$id_periodo,$anio,$mes);
        						
        						//-------
        						$sql = "UPDATE co_asiento
        							    SET 	estado_pago  =".$this->bd->sqlvalue_inyeccion('S', true)."
        							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idAsiento, true);
        						
        						$this->bd->ejecutar($sql);
        						
        						$sql = "UPDATE co_asiento_aux
        							    SET 	pago  =".$this->bd->sqlvalue_inyeccion('S', true)."
        							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idAsiento, true).' and
                                                idprov ='.$this->bd->sqlvalue_inyeccion($idprov, true);
        						
        						
        						$this->bd->ejecutar($sql);
						
 	    }	
						
 	}	
 //----------------
 	function K_aux_prov($cuenta){
 	    
 	    
 	    $AResultado = $this->bd->query_array('co_plan_ctas',
 	                                         'idprov', 
 	                                         'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and
                                              registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
 	                                       );
  
 	    return $AResultado["idprov"];
 	}	
 	//------------------------
 	function credito( $acuenta_iva,$acuentacxc,$id_periodo,$f1,$f2,$idbancos ,$tipofacturaf,$mes,$anio ){
 	    
 	    $sql ="SELECT
                        cuenta_ing ,
                        idprov    ,
                        max(comprobante) comprobante,
                        count(*) as nro_comprobantes,
                        sum(total) as total,
            	        sum(montoiva) as montoiva,
            	        sum(tarifa_cero) as tarifa_cero,
            	        sum(baseimponible) as baseimponible, max(id_movimiento) as id_movimiento,
                        max(fecha) as fecha
                    from view_inv_conta
                   where  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and
                         registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and trim(formapago) = 'credito'
                         group by cuenta_ing,idprov
                    order by idprov ";
 	    
 	    $stmt1 = $this->bd->ejecutar($sql);
 	    
 	    
 	    while ($x=$this->bd->obtener_fila($stmt1)){
 	        
 	        $detalle       = 'Facturacion del dia '.$x['fecha'].' Nro.'.$x['comprobante'];
 	        $valida        =  $x['baseimponible'] +  $x['tarifa_cero'] + $x['montoiva'];
 	        $cuenta_ing    = trim( $x['cuenta_ing'] );
 	        $ACuentaExiste = $this->bd->query_array('co_plan_ctas',
 	                                                'count(cuenta) as vale',
 	                                                'univel='.$this->bd->sqlvalue_inyeccion('S',true).' and
                                                     cuenta ='.$this->bd->sqlvalue_inyeccion($cuenta_ing,true).' and
                                                     registro ='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
 	            );

 	        if ($valida > 0){
 	            if ( $ACuentaExiste['vale'] > 0 ) {
 	                
 	                $this->agregar( $x['id_movimiento'],
             	                    $id_periodo,
             	                    $x['fecha'],
             	                    $cuenta_ing,
             	                    $x['comprobante'],
             	                    trim($x['idprov']),
             	                    $mes,
             	                    $anio,
             	                    $x['baseimponible'],
             	                    $x['tarifa_cero'],
             	                    $x['montoiva'],
             	                    0 ,
             	                    $detalle,
             	                    $acuenta_iva,
             	                    $acuentacxc,
             	                    $idbancos, 1 ,$f1,$f2,1
 	                    );
 	                
 	                $ContabilizadoVentas = '<b>Procesado de contabilizacion del periodo '.$f1.  ' al '.$f2.' '.$x['id_movimiento'].' </b>';
 	            }else  {
 	                $ContabilizadoVentas = '<b>DEBE CONFIGURAR LAS CUENTAS DE INGRESOS Y/O CUENTA POR COBRAR</b>';
 	            }
 	        }
 	        
 	    }
  
 	    
 	    return $ContabilizadoVentas;
 	    
 	}	
 	function pago_consumidor( $acuenta_iva,$acuentacxc,$id_periodo,$f1,$f2,$idbancos ,$tipofacturaf,$mes,$anio ){
 	    
 	    $sql ="SELECT
                        cuenta_ing ,
                        idprov    ,
                        max(comprobante) comprobante,
                        count(*) as nro_comprobantes,
                        sum(total) as total,
            	        sum(montoiva) as montoiva,
            	        sum(tarifa_cero) as tarifa_cero,
            	        sum(baseimponible) as baseimponible, max(id_movimiento) as id_movimiento,
                        max(fecha) as fecha
                    from view_inv_conta
                   where  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and
                         registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and trim(formapago) <> 'credito' 
                    group by cuenta_ing,idprov
                    order by idprov ";
 	    
 	    $stmt1 = $this->bd->ejecutar($sql);
 	    
 	  
 	    $idprov_banco = $this->K_aux_prov($idbancos);
 	    
 	    $long = strlen(trim($idprov_banco));
 	    
 	    if ( $long > 10)  {
 	        
             	    while ($x=$this->bd->obtener_fila($stmt1)){
             	        
             	        $detalle       = 'Facturacion del dia '.$x['fecha'].' Nro.'.$x['comprobante'];
             	        $valida        =  $x['baseimponible'] +  $x['tarifa_cero'] + $x['montoiva'];
             	        $cuenta_ing    = trim( $x['cuenta_ing'] );
             	        $ACuentaExiste = $this->bd->query_array('co_plan_ctas',
             	            'count(cuenta) as vale',
             	            'univel='.$this->bd->sqlvalue_inyeccion('S',true).' and
                                                                 cuenta ='.$this->bd->sqlvalue_inyeccion($cuenta_ing,true).' and
                                                                 registro ='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
             	            );
             	        
             	        if ($valida > 0){
             	            if ( $ACuentaExiste['vale'] > 0 ) {
             	             
             	                $this->agregar( $x['id_movimiento'],
             	                    $id_periodo,
             	                    $x['fecha'],
             	                    $cuenta_ing,
             	                    $x['comprobante'],
             	                    trim($x['idprov']),
             	                    $mes,
             	                    $anio,
             	                    $x['baseimponible'],
             	                    $x['tarifa_cero'],
             	                    $x['montoiva'],
             	                    0 ,
             	                    $detalle,
             	                    $acuenta_iva,
             	                    $acuentacxc,
             	                    $idbancos, 1 ,$f1,$f2,2
             	                    );
             	                
             	                $ContabilizadoVentas = '<b>Procesado pago del periodo '.$f1.  ' al '.$f2.' '.$x['id_movimiento'].' </b>';
             	            }else  {
             	                $ContabilizadoVentas = '<b>DEBE CONFIGURAR LAS CUENTAS DE INGRESOS Y/O CUENTA POR COBRAR</b>';
             	            }
             	        }
             	        
             	    }
 	    }else{
 	        $ContabilizadoVentas = '<b>DEFINA AUXILIAR BENEFICIARIO EN LA CUENTA DE CAJA/BANCOS PARA LA CONTABILIZACION</b>';
 	    }
 	    
 	    return $ContabilizadoVentas;
 	    
 	}	
 	//----------------
 	function K_actualizaInventario($idAsiento,$idmovimiento,$f1,$f2, $idprov ){
 	    
 	    
 	    $sql = "UPDATE inv_movimiento
				SET 	id_asiento_ref  =".$this->bd->sqlvalue_inyeccion($idAsiento, true)."
				WHERE 
                    (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and
                    idprov   =".$this->bd->sqlvalue_inyeccion($idprov, true);
 	    
 	    $this->bd->ejecutar($sql);
 	    
 	    
 	}	
 //----------------------------------
 	function AnexosTransacional($id_asiento,$idprov,$baseimpgrav,$tarifacero,$montoiva,$montoice,$secuencial,$fecha,$compro ){
 	    
     
 	    
 	    
 	    $tpidprov  = '04';
  	    $len          = strlen($idprov);
 	    
 	    if($len == 10)
 	        $tpidprov = '05';
 	        elseif($len == 13)
 	        $tpidprov = '04';
 	        
 	        if ($idprov == '9999999999999')     {
 	            $tpidprov = '07';
 	        }
 	        
 	        if ($idprov == '9999999999')     {
 	            $tpidprov = '07';
 	        }
 	        
  	 	        
 	        $this->ATabla[1][valor] =  $id_asiento;
 	        $this->ATabla[2][valor] =  $tpidprov;
 	        $this->ATabla[3][valor] =  $idprov;
 	        $this->ATabla[4][valor] =  '18';
 	        $this->ATabla[6][valor] = '0';
 	        
 	        $this->ATabla[7][valor] = $tarifacero;
 	        $this->ATabla[8][valor] =  $baseimpgrav;
 	        $this->ATabla[9][valor] = $montoiva;
 	        
 	        $this->ATabla[5][valor] = $compro;
 	        
 	        $this->ATabla[12][valor] = $secuencial;
  	        $this->ATabla[14][valor] = $fecha;
 	     
 
 	        $this->ATabla[10][valor] = '0';
 	        $this->ATabla[11][valor] =  '0';
 	        
 	       $id_compras = $this->bd->_InsertSQL('co_ventas',$this->ATabla,'-');
  
 	       return $id_compras;
 
 	
   }
 //-----------------------------------------
   function _Verifica_facturas(    ){
       
       $sqlEdit = "update inv_movimiento_det
				      set monto_iva = 0 ,
                          tarifa_cero = total / cantidad ,
                          baseiva = 0 ,
                          costo = total / cantidad "."
 				 		 WHERE  tarifa_cero is null and
                                cantidad > 0 and
                                monto_iva is null and
                                tipo=".$this->bd->sqlvalue_inyeccion('T', true);
       
       $this->bd->ejecutar($sqlEdit);
       
       
       //--------------
       $sqlEdit = "update inv_movimiento_det
				      set monto_iva = 0 ,
                          baseiva = 0
 				 		 WHERE  cantidad > 0 and
                                tarifa_cero > 0 and
                                monto_iva is null and
                                tipo=".$this->bd->sqlvalue_inyeccion('T', true);
       
       $this->bd->ejecutar($sqlEdit);
       
       //-----
       
       $sqlEdit = "update inv_movimiento_det
				      set tarifa_cero = 0
 				 		 WHERE  cantidad > 0 and
                                tarifa_cero is null and
                                monto_iva > 0 ";
       
       $this->bd->ejecutar($sqlEdit);
       
       //---------------
       
       
       $sql = "update inv_movimiento_det
                        set tipo = ".$this->bd->sqlvalue_inyeccion('T', true)."
                        where   cantidad > 0 and monto_iva = 0 and tipo is null" ;
       
       $this->bd->ejecutar($sql);
       
       
       $sql = "update inv_movimiento_det
                     set tarifa_cero = costo * cantidad,
                         total       = costo * cantidad
                   where  tipo = ".$this->bd->sqlvalue_inyeccion('T', true)." and
                          (monto_iva + tarifa_cero + baseiva) <> total" ;
       
       $this->bd->ejecutar($sql);
       
       
       //----------------
       $sqlEdit = "update inv_movimiento_det
				      set tarifa_cero = total / cantidad , baseiva = 0 ,costo = total / cantidad "."
 				 		 WHERE  cantidad = 1 and
                                monto_iva = 0 and total <> tarifa_cero  and
                                tipo=".$this->bd->sqlvalue_inyeccion('T', true);
       
       $this->bd->ejecutar($sqlEdit);
       
   }
   //---------------
   function _Verifica_suma_facturas(  ){
       
       
       $sql_det1 = "SELECT id_movimiento,    iva, base0, base12, total
                        FROM inv_movimiento
                        where (base0 is null  or iva is null ) and  estado = 'aprobado' ";
       
       $stmt1 = $this->bd->ejecutar($sql_det1);
       
       
       while ($x=$this->bd->obtener_fila($stmt1)){
           
           $id = $x['id_movimiento'];
           
           $ATotal = $this->bd->query_array(
               'inv_movimiento_det',
               'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
               ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
               );
           
           if ($ATotal['t1'] > 0) {
               
               $sqlEdit = "update inv_movimiento
        				           set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                                  base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                                  base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                                  total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
         				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
               
           } 
           
           $this->bd->ejecutar($sqlEdit);
           
           
       }
       
   }
   //----------------------------------------------
   //---------------
   function _Verifica_suma_facturas_Total(     ){
       
       
       $sql_det1 = "select   id_movimiento
                        FROM inv_movimiento
                        where ( iva + base0 + base12) <> total and    estado = 'aprobado'";
       
       
       
       $stmt1 = $this->bd->ejecutar($sql_det1);
       
       
       while ($x=$this->bd->obtener_fila($stmt1)){
           
           $id = $x['id_movimiento'];
           
           $ATotal = $this->bd->query_array(
               'inv_movimiento_det',
               'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
               ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
               );
           
           $sqlEdit = "update inv_movimiento
				     set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
           
           $this->bd->ejecutar($sqlEdit);
           
           
       }
       
   }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_GET["fecha1"]))	{
	
    $f1 			    =     $_GET["fecha1"];
    $f2 				=     $_GET["fecha2"];
    $idbancos           =     $_GET["idbancos"];
    $tipofacturaf       =     $_GET["tipofacturaf"];
    
    if ($idbancos <> '-' ) 	{
        $gestion->grilla( $f1,$f2,$idbancos,$tipofacturaf );
    }
    else{
        
        $ContabilizadoVentas = 'Seleccione el banco o caja para cierre de cuenta por cobrar';
        
        echo $ContabilizadoVentas;
    }
 
	
}



?>
 
  