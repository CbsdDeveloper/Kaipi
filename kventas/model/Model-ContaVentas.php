<?php
session_start( );

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php'; 

require 'Model-asientos_saldos.php';  


class proceso{
	
 
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $ATabla;
	private $anio;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
	 
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->anio       =  $_SESSION['anio'];
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
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
	function grilla( $f1,$f2,$idbancos ){
		
	    
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
	    //----------------------------------------------------------------
  	    $sql = "SELECT  cuenta_ing ,partida,cuentaxcobrar,sum(total) as total, sum(montoiva) as iva, 
            		 sum(tarifa_cero) as tarifa_cero, sum(baseimponible) as base
            from view_inv_conta 
            where  (fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
            group by cuenta_ing ,partida,cuentaxcobrar";
            
 
  	    
 
  	    $stmt1 = $this->bd->ejecutar($sql);
  	    
  	    $bandera = 1;
  	    
  	    while ($x=$this->bd->obtener_fila($stmt1)){
  	        
  	        $cuenta_ing     = trim($x['cuenta_ing']) ;
  	        $cuentaxcobrar  = trim($x['cuentaxcobrar']) ;
  	        $partida        = trim($x['partida']) ;
  	        
  	        $a = $this->_cuenta_valida($cuenta_ing);
  	        $b = $this->_cuenta_valida($cuentaxcobrar);
  	        $c = $this->_partida_valida($partida);
  	        
  	        if ($a < 1){
				echo 'Aqui '. $cuenta_ing.'<br';
  	            $bandera = 0;
  	        }
  	        if ($b < 1){
				echo 'Aqui '. $cuentaxcobrar.'<br';
  	            $bandera = 0;
  	        }
  	        if ($c < 1){
				echo 'Aqui '. $partida.'<br';
  	            $bandera = 0;
  	        }
  	        
  	    }
  	    
  

  	    if ( $bandera == 1){
  	        
  	        $detalle = 'GENERACION DE INGRESOS ... Emision de Facturacion del dia '.$f1.' al  '.$f2.' usuario: '.$this->sesion;
    	        
  	        $id_asiento =    $this->agregar_asiento( 0,
  	            $id_periodo,
  	            $f2,
  	            '',
  	            '-',
  	            '-',
  	            $mes,
  	            $anio,
  	            0,
  	            0,
  	            0,
  	            0 ,
  	            $detalle,
  	            '',
  	            '',$idbancos); 
  	        
  	            //-------------------------------------------------------------------------------
  	            $stmt2 = $this->bd->ejecutar($sql);
  	            
  	            $totalIva   = 0;
  	            $total_caja = 0;
  	            
  	            while ($x=$this->bd->obtener_fila($stmt2)){
  	                
  	                $total      = $x['base'] +  $x['tarifa_cero'];
  	                $totalIva   = $x['iva']  + $totalIva;
  	                $total_caja = $total     + $total_caja +  $x['iva'] ;
  	                
  	                $cuenta_ing     = trim($x['cuenta_ing']) ;
  	                $cuentaxcobrar  = trim($x['cuentaxcobrar']) ;
  	                $partida        = trim($x['partida']) ;
  	                
  	                $this->agregarDetalle( $id_asiento,$cuenta_ing,$id_periodo,$mes,$anio,0,$total,$partida);
  	                $this->agregarDetalle( $id_asiento,$cuentaxcobrar,$id_periodo,$mes,$anio,$total,0,$partida);
  	                
  	                $this->agregarDetalle( $id_asiento,$cuentaxcobrar,$id_periodo,$mes,$anio,0,$total,$partida);
  	                
  	            }
   	          
  	            
  	            if ( $totalIva > 0 ){
  	                
  	                $acuenta_iva =  $this->_cuenta_iva();
  	                $this->agregarDetalle( $id_asiento,trim($acuenta_iva),$id_periodo,$mes,$anio,0,$totalIva,'-') ;
  	                
  	            }
  	            
  	            if ( $total_caja > 0 ){
  	                
  	                $this->agregarDetalle( $id_asiento,trim($idbancos),$id_periodo,$mes,$anio,$total_caja,0,'-') ;
  	                
   	                
  	                $this->K_actualizaasiento($id_asiento,$total_caja);
  	                
  	                
  	                $this->saldos->_aprobacion($id_asiento);
  	                
  	                $this->K_actualizaInventario($id_asiento,$f1,$f2  );
  	                
  	            }
   	            
  	    }else{
  	        
  	        $ContabilizadoVentas = '<b>Defina el enlace con cuentas contables -  presupuesto</b>';
  	        
  	    }
  	    
    
 
	    $ContabilizadoVentas = '<b>Procesado de contabilizacion del periodo '.$f1.' al '.$f2.' Asiento: '.$id_asiento.'</b>';
  
	    echo $ContabilizadoVentas;
	    
 
 	    
	}
 //	-----------------------------------------------------
	function agregar_asiento( $id_movimiento,
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
	    $acuentacxc,$idbancos
	    ){
	        
	        $estado           =  'digitado';
	        
	        $total_apagar     =  $baseimpgrav+ $tarifacero  + $montoiva;
	        
	        $fecha		  = $this->bd->fecha($fecha1);
	        
	        $detalle = substr($detalle, 0,250);
	        
	        //------------------------------------------------------------
	        $sql = "INSERT INTO co_asiento(	fecha, registro,marca, anio, mes, detalle, sesion, creacion,modulo,
                						comprobante, estado, tipo, documento,idprov,cuentag,estado_pago,apagar, idmovimiento,
                                        id_periodo)
										        VALUES (".$fecha.",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion(1, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion($mes, true).",".
										        $this->bd->sqlvalue_inyeccion( $detalle, true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $this->hoy.",".
										        $this->bd->sqlvalue_inyeccion('cxcobrar', true).",".
										        $this->bd->sqlvalue_inyeccion('-', true).",".
										        $this->bd->sqlvalue_inyeccion($estado, true).",".
										        $this->bd->sqlvalue_inyeccion('R', true).",".
										        $this->bd->sqlvalue_inyeccion(trim($secuencial), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($idprov), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($cuenta), true).",".
										        $this->bd->sqlvalue_inyeccion( 'N', true).",".
										        $this->bd->sqlvalue_inyeccion( $total_apagar, true).",".
										        $this->bd->sqlvalue_inyeccion( $id_movimiento, true).",".
										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
										        
										        $this->bd->ejecutar($sql);

							 
										        
										        $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
		  return $idAsiento;
										       
	}
//------------------------------------------
	function agregarDetalle( $id,$cuenta,$id_periodo,$mes,$anio,$debe,$haber,$partida){
	    
	    
	        
	        $sql = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion,partida, creacion, principal,registro)
								VALUES (".
								$this->bd->sqlvalue_inyeccion($id , true).",".
								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
								$this->bd->sqlvalue_inyeccion( 'N', true).",".
								$this->bd->sqlvalue_inyeccion($debe, true).",".
								$this->bd->sqlvalue_inyeccion($haber, true).",".
								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$this->bd->sqlvalue_inyeccion( $anio, true).",".
								$this->bd->sqlvalue_inyeccion( $mes, true).",".
								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
								$this->bd->sqlvalue_inyeccion($partida , true).",".
								$this->hoy.",".
								$this->bd->sqlvalue_inyeccion( 'S', true).",".
								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
	  
 								
	    $this->bd->ejecutar($sql);
	    
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
//----------------
 	function _cuenta_valida($cuenta){
 	    
 	    
 	    $AResultado = $this->bd->query_array('co_plan_ctas',
 	        'count(*) as nn',
 	        'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and
               anio='.$this->bd->sqlvalue_inyeccion($this->anio,true).' and
            registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
 	        );
 	    
 	    return $AResultado["nn"];
 	}	
 	///-----------------------
 	function _cuenta_iva(){
 	    
 	    
 	    $AResultado = $this->bd->query_array('co_plan_ctas',
 	        'cuenta',
 	        'tipo_cuenta='.$this->bd->sqlvalue_inyeccion('G',true).' and
               anio='.$this->bd->sqlvalue_inyeccion($this->anio,true).' and
            registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
 	        );
 	    
 	    return $AResultado["cuenta"];
 	}	
 	//----------------
 	function _partida_valida($partida){
 	  
 
 	    
 	    $AResultado = $this->bd->query_array('presupuesto.pre_gestion',
 	        'count(*) as nn',
 	        'partida='.$this->bd->sqlvalue_inyeccion($partida,true).' and
               anio='.$this->bd->sqlvalue_inyeccion($this->anio,true) 
 	        );
 	    
 	    return $AResultado["nn"];
 	}	
 	//----------------
 	function K_actualizaInventario($idAsiento,$f1,$f2  ){
 	    
 	    
 	    $sql = "UPDATE inv_movimiento
							    SET 	id_asiento_ref  =".$this->bd->sqlvalue_inyeccion($idAsiento, true)."
							      WHERE tipo = 'F' and 
								  	    estado = 'aprobado' and 
								  	    id_asiento_ref is null and   
                                        ( fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."')" ;
 	    
 	    $this->bd->ejecutar($sql);
 	    
 	    
 	}	
 	
 	function K_actualizaasiento($idAsiento,$total){
 	    
 	    
 	    $sql = "UPDATE co_asiento
							    SET 	apagar  =".$this->bd->sqlvalue_inyeccion($total, true)."
							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idAsiento, true);
 	    
 	    $this->bd->ejecutar($sql);
 	    
 	    
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
    
    if ($idbancos <> '-' ) 	{
        
        $gestion->grilla( $f1,$f2,$idbancos );
        
    }
    else{
        
        $ContabilizadoVentas = 'Seleccione el banco o caja para cierre de cuenta por cobrar';
        
        echo $ContabilizadoVentas;
    }
 
	
}



?>
 
  