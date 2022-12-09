<?php
session_start( );

class saldo_contable{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function saldo_contable( $obj, $bd){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	$obj;
        $this->bd	   =	$bd ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        
    }
    //--------------------------------------------------------------------------------------
    //aprobación de asientos
    function _saldo_cxp($id){
        
        
        $estadoa = $this->bd->query_array('co_asiento',
            'idprov',
            'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $idprov		= $estadoa['idprov'];
        
        $x= $this->bd->query_array('view_aux',
            'sum(haber) as monto',
            'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true).' and
            idprov = '.$this->bd->sqlvalue_inyeccion($idprov,true)." and tipo_cuenta = 'P' "
            );
        
        if (  $x['monto'] > 0 ){
            
            $sql = "UPDATE co_asiento
						 SET apagar      =".$this->bd->sqlvalue_inyeccion( $x['monto'] , true)."
					   WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
        }
        
        
    }
    //-----------------
    function _aprobacion($id){
        
        $estadoa = $this->bd->query_array('co_asiento',
            'estado,fecha,id_periodo,tipo,anio',
            'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        $estado 		= $estadoa['estado'];
        $id_periodo		= $estadoa['id_periodo'];
        $fecha			= $this->bd->fecha($estadoa['fecha']);
        
        $bandera = 0;
        $comprobante = '-';
        
        if (trim($estado) == 'digitado'){
            $bandera = 1;
            //------------ verifica si el asiento esta cuadrado
            $sql =  "SELECT sum(debe) - sum(haber) as saldo
				 							FROM co_asientod
											WHERE id_asiento =".$this->bd->sqlvalue_inyeccion($id ,true);
            
            $parametros 	= $this->bd->ejecutar($sql);
            $saldos 		   =  $this->bd->obtener_array($parametros);
            
            if (  $saldos['saldo'] <> 0) {
                $this->obj->var->_alerta('Asiento no Cuadrado');
                $bandera = 0;
            }
            //-------------------auxiliares
            $sql = 'SELECT id_asientod,debe,haber
						             FROM co_asientod
						           WHERE aux ='.$this->bd->sqlvalue_inyeccion('S', true).' and
		                                 id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $stmt12 = $this->bd->ejecutar($sql);
            
            while ($x=$this->bd->obtener_fila($stmt12)){
                $id_asientod        = $x['id_asientod'];
                $total       		= $x['debe'] + $x['haber'];
                
                $sql = "SELECT count(*) as total,sum(debe)+sum(haber) as total_aux
						    					      FROM co_asiento_aux
						                            WHERE id_asientod =".$this->bd->sqlvalue_inyeccion($id_asientod ,true);
                
                $total_registro        = 0;
                $parametros 			= $this->bd->ejecutar($sql);
                $saldo_auxiliar 		= $this->bd->obtener_array($parametros);
                $total_registro         = $saldo_auxiliar['total'] ;
                $total_aux              = $saldo_auxiliar['total_aux'] ;
                
                if ($total_registro == 0){
                    $this->obj->var->_alerta('Asiento no tiene auxiliares');
                    $bandera = 0;
                }
                if ($total_aux <> $total ){
                    $this->obj->var->_alerta('Asiento los auxiliares, no cuadran con los detalles del asiento');
                    $bandera = 0;
                }
            }
            //----------- ESTADO Y APROBACION DEL ASIENTO
            if ($bandera == 1){
                
                $comprobante = $this->_Comprobante($estadoa["tipo"],$estadoa["anio"]);
                
                $sql = "UPDATE co_asiento
													   SET estado      =".$this->bd->sqlvalue_inyeccion('aprobado', true).",
														   comprobante =".$this->bd->sqlvalue_inyeccion($comprobante, true)."
													 WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($id, true);
                
                $this->bd->ejecutar($sql);
                
                $sql = " UPDATE co_asiento_aux
													    SET fecha =".$fecha.",
							                                id_periodo=".$this->bd->sqlvalue_inyeccion($id_periodo, true)."
													  WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($id, true);
                
                $this->bd->ejecutar($sql);
                
                $this->LibroDiario($id,$estadoa["detalle"],$fecha,$comprobante,$estadoa);
                
            }
        }
        
        return $comprobante;
    }
    //-----------------------------------------------------------------------------------------------------------
    //---   libro diario
    function LibroDiario($id,$detalle,$fecha,$comprobante,$datos ){
        
        $sql_det = 'SELECT cuenta,debe,haber,id_periodo,anio,mes,id_asientod
			                         FROM co_asientod
						           WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
        
        $stmt13 = $this->bd->ejecutar($sql_det);
        
        while ($x=$this->bd->obtener_fila($stmt13)){
            
            $sql_inserta = "INSERT INTO co_diario(
					                  			                      id_asiento, fecha, detalle, cuenta, debe, haber, id_periodo,anio, mes,
					                   			                      sesion, creacion, comprobante,id_asientod,registro) VALUES ( ".
					                   			                      $this->bd->sqlvalue_inyeccion($id, true).",".
					                   			                      $fecha.",".
					                   			                      $this->bd->sqlvalue_inyeccion($detalle, true).",".
					                   			                      $this->bd->sqlvalue_inyeccion($x['cuenta'], true).",".
					                   			                      $this->bd->sqlvalue_inyeccion($x['debe'], true).",".
					                   			                      $this->bd->sqlvalue_inyeccion($x['haber'], true).",".
					                   			                      $this->bd->sqlvalue_inyeccion($x['id_periodo'], true).",".
					                   			                      $this->bd->sqlvalue_inyeccion($x['anio'], true).",".
					                   			                      $this->bd->sqlvalue_inyeccion($x['mes'], true).",".
					                   			                      $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
					                   			                      $this->hoy.",".
					                   			                      $this->bd->sqlvalue_inyeccion($comprobante, true).",".
					                   			                      $this->bd->sqlvalue_inyeccion($x['id_asientod'], true).",".
					                   			                      $this->bd->sqlvalue_inyeccion($this->ruc, true).")";
					                   			                      
					                   			                      $this->bd->ejecutar($sql_inserta);
        }
        /////////////////////////////////////////////////////////////////////
        // suma de balance
        
        $sql_saldos = 'SELECT cuenta,debe,haber
                            FROM co_asientod
					       WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
        
        $stmt_saldos = $this->bd->ejecutar($sql_saldos);
        
        while ($x=$this->bd->obtener_fila($stmt_saldos)){
            
            $sql_uno = 'UPDATE  co_plan_ctas
				 		             SET  debe  = debe  + '.$this->bd->sqlvalue_inyeccion($x['debe'], true).',
						  	              haber = haber + '.$this->bd->sqlvalue_inyeccion($x['haber'], true).'
						            WHERE cuenta ='.$this->bd->sqlvalue_inyeccion(trim($x['cuenta']) ,true). ' and
		                                  registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true);
            
            $this->bd->ejecutar($sql_uno);
        }
        
    }
    //--------------------------------------------------------------------------
    function _Comprobante($tipo,$anio){
        
        
        $secuencia = $this->bd->query_array('co_asiento',
            'count(*) as doc',
            'tipo='.$this->bd->sqlvalue_inyeccion($tipo,true).' and
                                             anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
                                             registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true).' and
                                             estado='.$this->bd->sqlvalue_inyeccion( 'aprobado',true)
            );
        
        
        $contador 				= $secuencia['doc'] + 1;
        
        $input = str_pad($contador, 10, "0", STR_PAD_LEFT);
        
        return $input ;
    }
    ///------------------------
    function _elimina_asiento($id,$estado){
        
        
        if (trim($estado) == 'digitado'){
            
            $sql = 'delete from co_asiento_aux where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_compras where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_compras_f where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $sql = 'delete from co_asientod where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_asiento where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
        }
        //------------------
        if (trim($estado) == 'aprobado'){
            
            
            
            $sql = 'delete from co_asiento_aux where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_compras where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_compras_f where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            
            $sql = 'UPDATE co_asiento
        	         SET  	estado ='.$this->bd->sqlvalue_inyeccion('anulado', true).'
        	         WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $this->LibroDiarioElimina($id);
            
            
            /*
             if (trim($estado) == 'aprobado'){
             
             $sql = 'SELECT count(*) as refe
             FROM co_asiento_aux a
             WHERE a.id_asiento='.$this->bd->sqlvalue_inyeccion($id,true).' and a.id_asiento_ref > 0';
             
             $resultado      = $this->bd->ejecutar($sql);
             $datos_asiento  = $this->bd->obtener_array( $resultado);
             
             if ($datos_estado["refe"] == 0){
             
             
             
             }
             }
             */
        }
        
    }
    //------------------------
    function _elimina_asientocxc($id,$estado){
        
        
        if (trim($estado) == 'digitado'){
            
            $sql = 'delete from co_asiento_aux where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_ventas where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $sql = 'delete from co_asientod where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_asiento where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $sql = 'update inv_movimiento
                       set id_asiento_ref = 0
                     where id_asiento_ref='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            
        }
        //------------------
        if (trim($estado) == 'aprobado'){
            
            
            
            $sql = 'delete from co_asiento_aux where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'delete from co_ventas where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $sql = 'delete from co_asientod where id_asiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $sql = 'UPDATE co_asiento
        	         SET  	estado ='.$this->bd->sqlvalue_inyeccion('anulado', true).'
        	         WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            $sql = 'update inv_movimiento
                       set id_asiento_ref = 0
                     where id_asiento_ref='.$this->bd->sqlvalue_inyeccion($id, true);
            
            $this->bd->ejecutar($sql);
            
            
            $this->LibroDiarioElimina($id);
            
            
            
        }
        
    }
    
    
    /////////////// llena para consultar
    function LibroDiarioElimina($id ){
        
        $sql = 'DELETE
							    FROM  co_diario
								WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
        /////////////////////////////////////////////////////////////////////
        // suma de balance
        
        $sql_saldos = 'select cuenta,debe,haber
									 from co_asientod
									where id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);
        
        $stmt_saldos = $this->bd->ejecutar($sql_saldos);
        
        while ($x=$this->bd->obtener_fila($stmt_saldos)){
            
            $sql_uno = 'UPDATE co_plan_ctas
										 		  SET  debe = debe  - '.$this->bd->sqlvalue_inyeccion($x['1'], true).',
												  	   haber= haber - '.$this->bd->sqlvalue_inyeccion($x['2'], true).'
												  where cuenta ='.$this->bd->sqlvalue_inyeccion(trim($x['0']) ,true);
            
            $this->bd->ejecutar($sql_uno);
        }
        
        /*
         $sql_uno = 'UPDATE co_asiento_aux
         SET  debe='.$this->bd->sqlvalue_inyeccion(0, true).',
         haber='.$this->bd->sqlvalue_inyeccion(0, true).',
         pago='.$this->bd->sqlvalue_inyeccion('S', true).',
         bandera='.$this->bd->sqlvalue_inyeccion(2, true).',
         detalle='.$this->bd->sqlvalue_inyeccion('Anulado... ', true).' || detalle
         WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id ,true);
         
         $bd->ejecutar($sql_uno);*/
    }
    
    //------------------
    function _asiento_contable($fecha,$detalle,$tipo,$comprobante,$id_asiento,$modulo ,$documento,$idprov){
        
        $trozos = explode("-", $fecha,3);
        
        $anio =   $trozos[0];
        
        $mes =    $trozos[1];
        
        $periodo_s = $this->bd->query_array('co_periodo',
            'id_periodo',
            'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
          mes ='.$this->bd->sqlvalue_inyeccion($mes,true).' and
          anio='.$this->bd->sqlvalue_inyeccion($anio ,true)
            );
        
        if (empty($id_asiento)){
            $id_asiento = 0;
        }
        
        $fecha_registro		= $this->bd->fecha($fecha);
        
        $sql = "INSERT INTO co_asiento(   fecha, registro, anio, mes, detalle, sesion, creacion,
                                          comprobante, estado, tipo, documento,id_asiento_ref,
                                modulo,idprov,estado_pago,id_periodo)
                                VALUES (".$fecha_registro.",".
                                $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
                                $this->bd->sqlvalue_inyeccion($anio, true).",".
                                $this->bd->sqlvalue_inyeccion($mes, true).",".
                                $this->bd->sqlvalue_inyeccion($detalle, true).",".
                                $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
                                $this->hoy .",".
                                $this->bd->sqlvalue_inyeccion($comprobante, true).",".
                                $this->bd->sqlvalue_inyeccion('digitado', true).",".
                                $this->bd->sqlvalue_inyeccion($tipo, true).",".
                                $this->bd->sqlvalue_inyeccion($documento, true).",".
                                $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
                                $this->bd->sqlvalue_inyeccion($modulo, true).",".
                                $this->bd->sqlvalue_inyeccion($idprov, true).",".
                                $this->bd->sqlvalue_inyeccion('S', true).",".
                                $this->bd->sqlvalue_inyeccion( $periodo_s['id_periodo'], true).")";
                                
                                $this->bd->ejecutar($sql);
                                
                                $id_asiento_banco = $this->bd->ultima_secuencia('co_asiento');
                                
                                return $id_asiento_banco;
                                
                                
    }
    //-----------------------------------------------------
    function _detalle_contable($fecha,$idasiento_matriz,$cuenta,$debe,$haber){
        
        $trozos = explode("-", $fecha,3);
        
        $anio =   $trozos[0];
        
        $mes =    $trozos[1];
        
        $periodo_s = $this->bd->query_array('co_periodo',
            'id_periodo',
            'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
          mes ='.$this->bd->sqlvalue_inyeccion($mes,true).' and
          anio='.$this->bd->sqlvalue_inyeccion($anio ,true)
            );
        
        
        
        $x = $this->bd->query_array('co_plan_ctas',
            'aux',
            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true) .' and
             registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
            );
        
        $aux		= $x['aux'];
        
        
        $sql = " INSERT INTO co_asientod( id_asiento, cuenta, aux,debe, haber,id_periodo,anio,mes,sesion, creacion, registro)
                    				VALUES (".
                    				$this->bd->sqlvalue_inyeccion($idasiento_matriz , true).",".
                    				$this->bd->sqlvalue_inyeccion($cuenta, true).",".
                    				$this->bd->sqlvalue_inyeccion($aux, true).",".
                    				$this->bd->sqlvalue_inyeccion($debe, true).",".
                    				$this->bd->sqlvalue_inyeccion($haber, true).",".
                    				$this->bd->sqlvalue_inyeccion($periodo_s["id_periodo"], true).",".
                    				$this->bd->sqlvalue_inyeccion($anio, true).",".
                    				$this->bd->sqlvalue_inyeccion($mes, true).",".
                    				$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
                    				$this->hoy .",".
                    				$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
                    				
                    				$this->bd->ejecutar($sql);
                    				
                    				$id_asiento_banco_aux1 = $this->bd->ultima_secuencia('co_asientod');
                    				
                    				return    $id_asiento_banco_aux1;
                    				
    }
    //-------------------------------------------------------------------------
    function _aux_contable($fecha,$idasiento_matriz,$id_asiento_d,$detalle,$cuenta,$idprov,$debe,$haber,$id_asiento_ref,$pago,$cheque){
        
        $trozos = explode("-", $fecha,3);
        
        $anio =   $trozos[0];
        
        $mes =    $trozos[1];
        
        $periodo_s = $this->bd->query_array('co_periodo',
            'id_periodo',
            'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
          mes ='.$this->bd->sqlvalue_inyeccion($mes,true).' and
          anio='.$this->bd->sqlvalue_inyeccion($anio ,true)
            );
        
        
        $fecha_registro		= $this->bd->fecha($fecha);
        
        $sql = "INSERT INTO co_asiento_aux(id_asientod, id_asiento, idprov, cuenta,cheque,fecha,pago, detalle,debe, haber, id_periodo,
          									  anio, mes, sesion, creacion, id_asiento_ref,registro) VALUES (".
          									  $this->bd->sqlvalue_inyeccion($id_asiento_d  , true).",".
          									  $this->bd->sqlvalue_inyeccion($idasiento_matriz , true).",".
          									  $this->bd->sqlvalue_inyeccion($idprov , true).",".
          									  $this->bd->sqlvalue_inyeccion($cuenta , true).",".
          									  $this->bd->sqlvalue_inyeccion($cheque , true).",".
          									  $fecha_registro.",".
          									  $this->bd->sqlvalue_inyeccion($pago , true).",".
          									  $this->bd->sqlvalue_inyeccion($detalle , true).",".
          									  $this->bd->sqlvalue_inyeccion($debe , true).",".
          									  $this->bd->sqlvalue_inyeccion($haber , true).",".
          									  $this->bd->sqlvalue_inyeccion($periodo_s["id_periodo"] , true).",".
          									  $this->bd->sqlvalue_inyeccion($anio, true).",".
          									  $this->bd->sqlvalue_inyeccion($mes, true).",".
          									  $this->bd->sqlvalue_inyeccion($this->sesion , true).",".
          									  $this->hoy.",".
          									  $this->bd->sqlvalue_inyeccion($id_asiento_ref , true).",".
          									  $this->bd->sqlvalue_inyeccion($this->ruc , true).")";
          									  
          									  $this->bd->ejecutar($sql);
          									  
          									  
    }
}

?>
 
  