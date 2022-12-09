<?php
session_start( );

require '../../kconfig/Db.class.php';

require '../../kconfig/Obj.conf.php';

//require 'Model-asientos_saldos.php';


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
        
        $this->ruc       =  trim($_SESSION['ruc_registro']);
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
        
        //$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
        
 
        
        
        
    }
    
    //--- calcula libro diario
    function grilla( $parte_caja,$fecha_caja){
        
        
        $array_fecha   = explode("-", $fecha_caja);
        
        $mes           = $array_fecha[1];
        $anio          = $array_fecha[0];
        
        
       $existe = $this->_valida_asiento($parte_caja,$fecha_caja);
        
        //------------ seleccion de periodo
        
        $periodo_s = $this->bd->query_array('co_periodo',
            'id_periodo',
            'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
             anio ='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
             mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
            );
        
       
        if ( $existe['contabilizado'] > 0 ){
            
            $ContabilizadoVentas = '<b>Procesado de contabilizacion del periodo  Asiento: '.$existe['contabilizado'].'</b>';
        
        }else{
            
            $id_periodo = $periodo_s['id_periodo'];
            
            $detalle = 'GENERACION DE INGRESOS ... PARTE RECAUDACION '.$parte_caja.' del dia '.$fecha_caja.' usuario: '.$this->sesion;
            
            
            $tramite = $existe['tramite'];
            
            $id_asiento =    $this->agregar_asiento( 0,
                $id_periodo,
                $fecha_caja,
                '',
                $parte_caja,
                $this->ruc,
                $mes,
                $anio,
                0,
                0,
                0,
                0 ,
                $detalle,
                '',
                '','-',$tramite);
            
                
            
             
                $sql = "SELECT parte, fecha, cuenta, partida, debe, haber, sesion, tramite, contabilizado
                FROM public.co_asientod_manual
                where parte=".$this->bd->sqlvalue_inyeccion(trim($parte_caja) ,true)." and
                     fecha=".$this->bd->sqlvalue_inyeccion($fecha_caja ,true);
           
                $stmt1 = $this->bd->ejecutar($sql);
                
                while ($x=$this->bd->obtener_fila($stmt1)){
                    
                    $cuenta         = trim($x['cuenta']) ;
                    $partida        = trim($x['partida']) ;
                    
                    $debe = $x['debe'];
                    $haber= $x['haber'];
                    
                    $this->agregarDetalle( $id_asiento,$cuenta,$id_periodo,$mes,$anio,$debe,$haber,$partida);
                    
                    
                }
              
                $this->K_actualizaParte($id_asiento,$parte_caja,$fecha_caja );
        
            $ContabilizadoVentas = '<b>Procesado de contabilizacion del periodo  Asiento: '.$id_asiento.'</b>';
        }
        
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
        $acuentacxc,$idbancos,$tramite
        ){
            
            $estado           =  'digitado';
            $total_apagar     =  $baseimpgrav+ $tarifacero  + $montoiva;
            $fecha		      = $this->bd->fecha($fecha1);
            $detalle          = substr($detalle, 0,250);
            
            
            
            //------------------------------------------------------------
            $sql = "INSERT INTO co_asiento(	fecha, registro,marca, anio, mes, detalle, sesion, creacion,modulo,
                						comprobante, estado, tipo, documento,idprov,cuentag,estado_pago,apagar, id_tramite,idmovimiento,
                                        id_periodo)
										        VALUES (".$fecha.",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion(1, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion($mes, true).",".
										        $this->bd->sqlvalue_inyeccion( $detalle, true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $this->hoy.",".
										        $this->bd->sqlvalue_inyeccion('contabilidad', true).",".
										        $this->bd->sqlvalue_inyeccion('-', true).",".
										        $this->bd->sqlvalue_inyeccion($estado, true).",".
										        $this->bd->sqlvalue_inyeccion('R', true).",".
										        $this->bd->sqlvalue_inyeccion(trim($secuencial), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($idprov), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($cuenta), true).",".
										        $this->bd->sqlvalue_inyeccion( 'N', true).",".
										        $this->bd->sqlvalue_inyeccion( $total_apagar, true).",".
										        $this->bd->sqlvalue_inyeccion( $tramite, true).",".
										        $this->bd->sqlvalue_inyeccion( $id_movimiento, true).",".
										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
										        
										        $this->bd->ejecutar($sql);
										        
										        $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
										        
										        return $idAsiento;
										        
    }
    //------------------------------------------
    function agregarDetalle( $id,$cuenta,$id_periodo,$mes,$anio,$debe,$haber,$partida){
        
        
        $datos = $this->_cuenta_aux($cuenta);
        
        
        $aux    = $datos["aux"];
        $idprov = $this->ruc;
        
        $principal = 'N';
        
        if ( $datos["partida_enlace"] == 'gasto'){
            $principal = 'S';
        }
        
        $sql = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion,partida, creacion, principal,registro)
								VALUES (".
								$this->bd->sqlvalue_inyeccion($id , true).",".
								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
								$this->bd->sqlvalue_inyeccion( $aux, true).",".
								$this->bd->sqlvalue_inyeccion($debe, true).",".
								$this->bd->sqlvalue_inyeccion($haber, true).",".
								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$this->bd->sqlvalue_inyeccion( $anio, true).",".
								$this->bd->sqlvalue_inyeccion( $mes, true).",".
								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
								$this->bd->sqlvalue_inyeccion($partida , true).",".
								$this->hoy.",".
								$this->bd->sqlvalue_inyeccion( $principal, true).",".
								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
								
								
								$this->bd->ejecutar($sql);
								
								$id_asientod =  $this->bd->ultima_secuencia('co_asientod');
								
								if ( $aux == 'S'){
								    $this->K_aux($id_asientod,$id,$idprov,$cuenta,$debe,$haber,$id_periodo,$anio,$mes);
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
     
    ///-----------------------
    function _valida_asiento($parte_caja,$fecha_caja){
        
        
        $AResultado = $this->bd->query_array('co_asientod_manual',
            'max(contabilizado) as contabilizado,max(tramite) as tramite',
            'parte='.$this->bd->sqlvalue_inyeccion($parte_caja,true).' and
               fecha='.$this->bd->sqlvalue_inyeccion($fecha_caja,true) 
            );
        
        return $AResultado;
    }
    ///-----------------------
    function _cuenta_aux($cuenta){
        
        
        $AResultado = $this->bd->query_array('co_plan_ctas',
            'aux,partida_enlace ',
            'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and
               anio='.$this->bd->sqlvalue_inyeccion($this->anio,true).' and
            registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
            );
        
        return $AResultado;
    }
    
    //----------------
    function K_actualizaParte($idAsiento,$parte_caja,$fecha_caja ){
        
        
        $sql = "UPDATE co_asientod_manual
							    SET 	contabilizado  =".$this->bd->sqlvalue_inyeccion($idAsiento, true)."
							      WHERE parte=".$this->bd->sqlvalue_inyeccion(trim($parte_caja),true)."  and 
                                       fecha=" .$this->bd->sqlvalue_inyeccion($fecha_caja,true);
        
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
if (isset($_GET["fecha_caja"]))	{
    
    $parte_caja 			    =     $_GET["parte_caja"];
    $fecha_caja 				=     $_GET["fecha_caja"];
    $gestion->grilla( $parte_caja,$fecha_caja);
        
    
    
}



?>
 
  