<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  


require '../../kcontabilidad/model/Model-asientos_saldos.php';


class proceso{
	
 
	
	private $obj;
	private $bd;
	private $bd_cat;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;

	private $ATablaPago;
	private $tabla ;
	private $secuencia;
    private $saldos;
	
	private $estado_periodo;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->bd_cat	   =	 	new Db ;

		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     trim($_SESSION['email']);
		
        $this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	 
        $this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		 
		
	}
 
	//-----------------------------------------------------------
 
	function AprobarComprobante( ){
	    

        $x = $this->bd->query_array('rentas.view_diario_caja ',   
        'sum(debe) as total, max(cuenta) as cuenta',                  
        'opago='.$this->bd->sqlvalue_inyeccion('1',true) ." and estado_pago= 'N' "
        );


        $total_apagar = $x['total'];
        $cuenta_caja  = trim($x['cuenta']);



        $fecha_registro  = trim($_POST["fecha"]);
        $estado          =  'digitado';
        $fecha		     = $this->bd->fecha($fecha_registro);

        $detalle        =  trim($_POST["detalle"]);
 
        $valida         = strlen($detalle );

        $secuencial     =  trim($_POST["documento"]);
        $idprov         =  $this->ruc     ;
        $cuenta         =  trim($_POST["idbancos"]);
        $tramite        = 0;
        $id_movimiento  = 0;

        $tipo_mov = 'B';

        $array_fecha   = explode("-", $fecha_registro);
        
        $mes           = $array_fecha[1];
        $anio          = $array_fecha[0];


        $periodo_s = $this->bd->query_array('co_periodo',
        'id_periodo',
        'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
         anio ='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
         mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
        );
         

        $id_periodo = trim($periodo_s["id_periodo"]);

        if (  $valida >  10  ) {

     
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
                                                        $this->bd->sqlvalue_inyeccion('bancos', true).",".
                                                        $this->bd->sqlvalue_inyeccion('-', true).",".
                                                        $this->bd->sqlvalue_inyeccion($estado, true).",".
                                                        $this->bd->sqlvalue_inyeccion($tipo_mov, true).",".
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


                            $id_asiento_d =  $this->agregar_detalle($idAsiento,$cuenta_caja,'-' ,'0.00',$total_apagar,$id_periodo,$anio,$mes);

                            $this->saldos->_aux_contable_bancos($fecha_registro,$idAsiento,
                            $id_asiento_d,
                            $detalle,
                            $cuenta_caja,
                            $this->ruc,
                            '0.00',$total_apagar,
                            0,
                            'N',
                            '0',
                            'transferencia',
                            '0');


                            $id_asiento_d1 =  $this->agregar_detalle($idAsiento,$cuenta,'-' ,$total_apagar,'0.00',$id_periodo,$anio,$mes);

                            $this->saldos->_aux_contable_bancos($fecha_registro,$idAsiento,
                            $id_asiento_d1,
                            $detalle,
                            $cuenta,
                            $this->ruc,
                            $total_apagar,'0.00',
                            0,
                            'N',
                            '0',
                            'transferencia',
                            '0');


                            $comprobante =  $this->saldos->_aprobacion($idAsiento);
                        
                            if ($comprobante <> '-')	{
                            
                                        $sql = " UPDATE co_asiento
                                        SET 	estado_pago=".$this->bd->sqlvalue_inyeccion('S', true).", opago = 2
                                        WHERE estado_pago = 'N' and
                                            tipo = 'X' and
                                            opago=".$this->bd->sqlvalue_inyeccion('1' , true) ;
                            
                            
                                    $this->bd->ejecutar($sql);

                
                                    echo '<script type="text/javascript">';
                        
                                    echo  'LimpiarPantalla();';
                                    
                                    echo '</script>';


                                $result = ' SE APROBO EL ASIENTO NRO. DE CAJA BANCOS '.  $idAsiento .'<br> ' ;
                            
                            }else{
                                
                                $result = $result .' NO SE APROBO EL ASIENTO... REVISE AUXILIARES - ENLACES PRESUPUESTARIOS INGRESO - GASTO <br> ';

                            }
           }else{
                                
            $result = $result .' REGISTRE EL DETALLE DE LA TRANSACCION....<br> ';

        }

        

             echo  $result;
 
	         
	        
	}

    /*
    */
 	 
 	  function agregar_detalle($id_asiento,$cuenta,$partida ,$debe,$haber,$id_periodo,$anio,$mes){
        
        


        $datos = $this->_cuenta_seleccion($cuenta);

        $aux       = $datos["aux"];

        if ($datos["partida_enlace"] == '-') {
            $principal = 'N';
        }else {
            $principal = 'S';
        }
 
        $xxx = $this->bd->query_array('presupuesto.pre_gestion',
		'item',
		'anio='.$this->bd->sqlvalue_inyeccion($anio,true) .' and 
	  	partida='.$this->bd->sqlvalue_inyeccion($partida,true)
		);
	
 
		$item =  trim($xxx['item']); 


                    $sql = "INSERT INTO co_asientod(
                        id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
                        sesion,partida,item, creacion, principal,registro)
                        VALUES (".
                        $this->bd->sqlvalue_inyeccion($id_asiento , true).",".
                        $this->bd->sqlvalue_inyeccion( trim($cuenta), true).",".
                        $this->bd->sqlvalue_inyeccion( $aux, true).",".
                        $this->bd->sqlvalue_inyeccion($debe, true).",".
                        $this->bd->sqlvalue_inyeccion($haber, true).",".
                        $this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
                        $this->bd->sqlvalue_inyeccion( $anio, true).",".
                        $this->bd->sqlvalue_inyeccion( $mes, true).",".
                        $this->bd->sqlvalue_inyeccion($this->sesion , true).",".
                        $this->bd->sqlvalue_inyeccion($partida , true).",".
                        $this->bd->sqlvalue_inyeccion($item , true).",".
                        $this->hoy.",".
                        $this->bd->sqlvalue_inyeccion( $principal, true).",".
                        $this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
                        
                        
                        $this->bd->ejecutar($sql);

                        $id_asiento_d = $this->bd->ultima_secuencia('co_asientod');
                        
                        return $id_asiento_d;
         
    }
       /*
   */
  function _cuenta_seleccion($cuenta){
        
        
    $AResultado = $this->bd->query_array('co_plan_ctas',
        '*',
        'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and
           anio='.$this->bd->sqlvalue_inyeccion($this->anio,true).' and
        registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true)
        );
    
    return $AResultado;
}

///-------------------------------------------
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
 
 
//---------------------------
    if (isset($_POST["action"]))	{
        
         
        $accion  = trim($_POST["action"]);
 

         
        if ($accion == 'caja'){
            
            $gestion->AprobarComprobante( );

        } 
        
        
    }

?>
 
  