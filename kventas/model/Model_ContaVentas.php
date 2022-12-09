<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'contabilidad.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    private $contabilidad;
    
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
        
        $this->obj                 = 	new objects;
        $this->bd	               =	new Db ;
        $this->contabilidad	       =	new conta ;
        
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->contabilidad->db(  $this->bd );
        
         
        $this->ATabla = array(
            array( campo => 'id_ventas',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_asiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'tpidcliente',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idcliente',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'numerocomprobantes',tipo => 'NUMBER',id => '5',add => 'S', edit => 'N', valor => '1', key => 'N'),
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
    function grilla( $id, $fecha ){
        
        $array_fecha   = explode("-", $fecha);
        $mes           = $array_fecha[1];
        $anio          = $array_fecha[0];
        $idbancos      = 0;
        
        $id_periodo =  $this->contabilidad->periodo($fecha);
       
        $acuenta_iva =  $this->contabilidad->iva_ventas();
  
        $acuentacxc  = $this->contabilidad->cuentaxcobrar();
  
        //------------------------------------------------------------------
        
        $sql ="SELECT  id_movimiento,  cuenta_ing  ,  fecha, idprov  ,   comprobante,  total, montoiva, tarifa_cero,  baseimponible,detalle,carga
               FROM view_inv_conta
               WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id,true)."
              ORDER BY fecha";
        
        $stmt1 = $this->bd->ejecutar($sql);
        
        if ($id_periodo <> '0' ){
            if ($acuenta_iva <> '0' ){
                if ($acuentacxc <> '0' ){
                    //-------------------------------------------------------
                    //-------------------------------------------------------
                    while ($x=$this->bd->obtener_fila($stmt1)){
                        
                        $cuenta_ing    = trim( $x['cuenta_ing'] );
                        
                        $valida_cuenta = $this->contabilidad->valida_cuenta($cuenta_ing);
                        
                        $detalle = trim($x['detalle']).$x['fecha'].' Nro.'.$x['comprobante'];
                        $detalle = substr($detalle, 0,200);
                        $valida =  $x['baseimponible'] +  $x['tarifa_cero'] + $x['montoiva'];
                       
                        if ($valida > 0){
                            
                            if ( $valida_cuenta == 1 )    {
                                
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
                                    $acuentacxc,$idbancos,$x['carga']);
                                
                                   $ContabilizadoVentas = '<b>Contabilizado Nro.Asiento'.$x['id_movimiento'].' </b>';
                                
                            }else {
                                $ContabilizadoVentas = '<b>No contabilizado  '.$x['id_movimiento'].'- Cuenta no definida de ingresos '.$cuenta_ing.'</b>';
                            }
                        }else{
                            $ContabilizadoVentas = '<b>No existe valor para contabilizar</b>';
                        }
                    }
                    //-------------------------------------------------------
                    //-------------------------------------------------------
                }else{
                    $ContabilizadoVentas ='No existe cuenta por cobrar parametrizada';
                }
             }else{
                $ContabilizadoVentas ='No existe cuenta de iva en ventas parametrizada';
            }
         }else{
            $ContabilizadoVentas ='No existe periodo creado';
        }
        
        /*    
        //------------------------------------------------------------------
     /*  
        //----------------------------------------------------------------
        
        if (!empty($acuentacxc)){
            
            
            if (!empty($acuenta_iva)){
                
               
   
                
               
                
                while ($x=$this->bd->obtener_fila($stmt1)){
                    
                    $detalle = trim($x['detalle']).$x['fecha'].' Nro.'.$x['comprobante'];
                    
                    $detalle = substr($detalle, 0,200);
                    
                    $valida =  $x['baseimponible'] +  $x['tarifa_cero'] + $x['montoiva'];
                    
                    if ($valida > 0){
                        
                        $cuenta_ing = trim( $x['cuenta_ing'] );
                        
                        $ACuentaExiste = $this->bd->query_array('co_plan_ctas',
                                'count(cuenta) as vale',
                                'univel='.$this->bd->sqlvalue_inyeccion('S',true).' and
                                 cuenta ='.$this->bd->sqlvalue_inyeccion($cuenta_ing,true).' and
                                 registro ='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
                            );
                        
                     
                        $detalle = substr(trim($detalle), 0,200);
                        
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
                                $acuentacxc,$idbancos,$x['carga']);
                            
                            $ContabilizadoVentas = '<b>Tramite contabilizado Nro.Asiento'.$x['id_movimiento'].' </b>';
                            
                        }else{
                            $ContabilizadoVentas = '<b>No contabilizado  '.$x['id_movimiento'].'-'.$cuenta_ing.'</b>';
                        }
                    }
                    
                    
                }
            } else    {
                $ContabilizadoVentas = '<b>DEBE CONFIGURAR LAS CUENTAS DE INGRESOS Y/O CUENTA POR COBRAR</b>';
            }
        }else
        {
            $ContabilizadoVentas = '<b>DEBE CONFIGURAR LAS CUENTAS DE INGRESOS Y/O CUENTA POR COBRAR</b>';
        }
        
        */
        echo $ContabilizadoVentas;
        
        
        
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
        $acuentacxc,$idbancos,$carga_datos
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
										        
										        
										        
										        if ( $carga_datos <> '9'){
										            
										            $this->AnexosTransacional($idAsiento,trim($idprov),$baseimpgrav,$tarifacero,$montoiva,$montoice,$secuencial,$fecha1);
										            
										        }
										        
										        /*
										        //--- forma de pago
										        $sqlBanco = 'SELECT formapago, tipopago, monto, idbanco, cuenta, riva, rfuente, idfacpago, fecha, sesion
 		               FROM inv_fac_pago
                      where id_movimiento ='. $this->bd->sqlvalue_inyeccion( $id_movimiento, true);
										        
										        $SmtpBanco = $this->bd->ejecutar($sqlBanco);
										        
										        while ($y=$this->bd->obtener_fila($SmtpBanco)){
										            
										            if ( trim($y['formapago']) == 'contado'){
										                
										                $this->K_clienteCierre($idAsiento,$mes,$anio,$id_periodo,$total_apagar,$acuentacxc,trim($idprov));
										                
										                $this->K_Banco($idAsiento,$mes,$anio,$id_periodo,$total_apagar,$idbancos);
										                
										            }
										            
										            
										        }
										        */
										        //----------
										      //  $this->saldos->_aprobacion($idAsiento);
										        
										        $this->K_actualizaInventario($idAsiento,$id_movimiento);
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
    //----------------
    function K_actualizaInventario($idAsiento,$idmovimiento){
        
        
        $sql = "UPDATE inv_movimiento
							    SET 	id_asiento_ref  =".$this->bd->sqlvalue_inyeccion($idAsiento, true)."
							      WHERE id_movimiento   =".$this->bd->sqlvalue_inyeccion($idmovimiento, true);
        
        $this->bd->ejecutar($sql);
        
        
    }
    //----------------------------------
    function AnexosTransacional($id_asiento,$idprov,$baseimpgrav,$tarifacero,$montoiva,$montoice,$secuencial,$fecha ){
        
          
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
            
            $this->ATabla[12][valor] = $secuencial;
            $this->ATabla[14][valor] = $fecha;
            
            
            $this->ATabla[10][valor] = '0';
            $this->ATabla[11][valor] =  '0';
            
            $id_compras = $this->bd->_InsertSQL('co_ventas',$this->ATabla,'-');
            
            return $id_compras;
            
            
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
if (isset($_GET["id"]))	{
    
    $id     = $_GET["id"];
    
    $fecha  = $_GET["fecha"];
    
    
    $gestion->grilla( $id, $fecha);
    
}
    
 

?>
 
  