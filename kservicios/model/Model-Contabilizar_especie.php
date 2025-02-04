<?php
session_start( );

require '../../kconfig/Db.class.php';

require '../../kconfig/Obj.conf.php';

require '../../kcontabilidad/model/Model-asientos_saldos.php';


class proceso{
    
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $ATabla;
    private $anio;

    private $saldos;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  trim($_SESSION['ruc_registro']);

        $this->sesion 	 =  trim($_SESSION['email']);

        $this->hoy 	     =     date("Y-m-d");    
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];

         
        $this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
        
 
        
        
        
    }
    
    
    //--- calcula libro diario

    function contabilidad( $fecha ){
        

        $array_fecha   = explode("-", $fecha);
        
        $mes           = $array_fecha[1];
        $anio          = $array_fecha[0];


        $periodo_s = $this->bd->query_array('co_periodo',
        'id_periodo',
        'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
         anio ='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
         mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
        );
 
       $valida_emision =   $this->existe_emision($cajero,$fecha);



        $result = ' EMISION YA GENERADA... verifique la informacion <br> ';


        $valida_cuenta = $this->valida_cuenta($cajero,$fecha );

 
        //--------------------------------------------
        // contabilizacion de emision de titulos
        //--------------------------------------------
        if (  $valida_emision == 1){

            if (  $valida_cuenta == 1){

                    $idasiento = $this->agregar_asiento( $mes , $anio,  $fecha,$cajero ,$periodo_s['id_periodo'],$parte,'62','R' );

                   if ($idasiento > 0 ) {

                        $this->agregar_asiento_demision(  $mes , $anio,  $fecha,$cajero ,$periodo_s['id_periodo'],$parte, $idasiento );

                       $comprobante =  $this->saldos->_aprobacion($idasiento);

                
                        if ($comprobante <> '-')	{
                        
                           $this->_actualiza_emision($idasiento,$cajero,$fecha );

                            $result = ' SE APROBO EL ASIENTO NRO. DE EMISION '.  $idasiento .'<br> ' ;
                        
                        }else{
                            
                            $result = $result .' NO SE APROBO EL ASIENTO... REVISE AUXILIARES - ENLACES PRESUPUESTARIOS INGRESO - GASTO <br> ';

                        }
                    }
            }else   {
                            
                $result = $result .' NO SE GENERO EL ASIENTO... VERIFIQUE LA PARAMETRIZACIÓN DE LAS CUENTAS CONTABLES <br> ';

            }      
         }else{
 
            $result = $result . ' PROCESO EMISION CONTABILIZADO...<br> ';

        }
      
 
        echo $result;
    }
    //	-----------------------------------------------------
    function agregar_asiento( $mes , $anio,  $fecha_registro,$cajero ,$id_periodo,$parte , $cuenta ,$tipo_mov ){
            
             $estado         =  'digitado';

             $fecha		     = $this->bd->fecha($fecha_registro);

           
                 $detalle        = 'Registro de emision de Especies consolidado dia: '.$fecha_registro;
          

             $secuencial     =  $anio.'-'.$mes.'-00';
             $idprov         =  $this->ruc     ;
             $cuenta         =  $cuenta;
             $total_apagar   =  0;
             $tramite        =  0;
             $id_movimiento  =  0;
            //------------------------------------------------------------
            $sql = "INSERT INTO co_asiento(	fecha, registro,marca, anio, mes, detalle, sesion, creacion,modulo,
                						comprobante, estado, tipo, documento,idprov,archivo,cuentag,estado_pago,apagar, id_tramite,idmovimiento,
                                        id_periodo)
										        VALUES (".$fecha.",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion(1, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion($mes, true).",".
										        $this->bd->sqlvalue_inyeccion( $detalle, true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $fecha.",".
										        $this->bd->sqlvalue_inyeccion('contabilidad', true).",".
										        $this->bd->sqlvalue_inyeccion('-', true).",".
										        $this->bd->sqlvalue_inyeccion($estado, true).",".
										        $this->bd->sqlvalue_inyeccion($tipo_mov, true).",".
										        $this->bd->sqlvalue_inyeccion(trim($secuencial), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($idprov), true).",".
                                                $this->bd->sqlvalue_inyeccion(trim('E'), true).",".
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
  /*
  emision de ingresos
  */
    function agregar_asiento_demision(  $mes , $anio,  $fecha,$cajero ,$id_periodo,$parte, $idasiento  ){
        
        
        
        $principal = 'N';
        
        if ( trim($datos["partida_enlace"]) == 'gasto'){
            $principal = 'S';
        }

        //---------- emision de datos
            $sqlEmi = "SELECT    cxcobrar, cuenta_ing, partidaa, cxcobrar_aa, cuenta_aa,sum(total) as total
            FROM rentas.view_contabilizacion_espe
            where total > 0 and 
                estado = 'P' and 
                conta = 'N' and 
                fecha = ".$this->bd->sqlvalue_inyeccion(trim($fecha), true)."
            group by cxcobrar, cuenta_ing, partidaa, cxcobrar_aa, cuenta_aa";

           //---------------  especies 911
           $sql = "SELECT    cxcobrar, cuenta_ing, partidaa, cxcobrar_aa, cuenta_aa, (sum(total_costo)) as total
           FROM rentas.view_contabilizacion_espe
           where  
                 estado = 'P' and 
                 conta = 'N' and 
                 fecha = ".$this->bd->sqlvalue_inyeccion(trim($fecha), true)."
           group by cxcobrar, cuenta_ing, partidaa, cxcobrar_aa, cuenta_aa";

        
  
           $stmt2 = $this->bd->ejecutar($sql);

           $stmt1 = $this->bd->ejecutar($sqlEmi);
   
           while ($fila1=$this->bd->obtener_fila($stmt2)){
                               
             $cxcobrar   =  trim($fila1["cxcobrar"]);        
             $cuenta_ing =  trim($fila1["cuenta_ing"]);        
           
             $debe   =  $fila1["total"]  ;
             $haber  =  '0.00';
 
              $this->agregar_detalle($idasiento,$cxcobrar,'-' ,$debe,$haber,$id_periodo,$anio,$mes);
              $this->agregar_detalle($idasiento,$cuenta_ing,'-' ,$haber,$debe,$id_periodo,$anio,$mes);
                      
           }
         
        //----------------- emision de datos   
          $total = 0;   

          while ($fila=$this->bd->obtener_fila($stmt1)){
                              
            $partida    =  trim($fila["partidaa"]);        
            $cxcobrar   =  trim($fila["cxcobrar"]);        
            $cuenta_ing =  trim($fila["cuenta_ing"]);        

            $cxcobrari   =  trim($fila["cxcobrar_aa"]);        
            $cuenta_ingi =  trim($fila["cuenta_aa"]);       
         
            $debe   =  $fila["total"]  ;
            $haber  =  '0.00';
 
            $this->agregar_detalle($idasiento,$cxcobrari,$partida ,$debe,$haber,$id_periodo,$anio,$mes);

            $this->agregar_detalle($idasiento,$cuenta_ingi,$partida ,$haber,$debe,$id_periodo,$anio,$mes);

            $this->agregar_detalle($idasiento,$cxcobrari,$partida ,$haber,$debe,$id_periodo,$anio,$mes);

            $total =  $fila["total"]  + $total;   
                              
          }
 
        /*  cierre de caja */
          $datos =  $this->caja_recaudadora();

          $cuenta_ing   =    trim($datos["cuenta"]);   
          $idprov       =    trim($datos["idprov"]);   

          $debe   =   $total  ;
          $haber  =  '0.00';
    
          $id_asiento_d =  $this->agregar_detalle($idasiento,$cuenta_ing,'-' ,$debe,$haber,$id_periodo,$anio,$mes);
    
          $detalle        = 'Registro de Recaudacion de ingresos dia: '.$fecha.' usuario: '.$cajero ;
    
          $this->saldos->_aux_contable_bancos($fecha,$idasiento,
                                              $id_asiento_d,
                                              $detalle,
                                              $cuenta_ing,
                                              $idprov,
                                              $debe,$haber,
                                              0,
                                              'N',
                                              '0',
                                              'transferencia',
                                              '0');
 	
								
    }
  
  /*
  detalle de asientos
  */
    function agregar_detalle($id_asiento,$cuenta,$partida ,$debe,$haber,$id_periodo,$anio,$mes){
        
        

        $datos = $this->_cuenta_seleccion($cuenta);

        $aux       = $datos["aux"];

        if (trim($datos["partida_enlace"]) == '-') {
            $principal = 'N';
        }else {
            $principal = 'S';
        }
 
        $xxx = $this->bd->query_array('presupuesto.pre_gestion',
		'item',
		'anio='.$this->bd->sqlvalue_inyeccion($anio,true) .' and 
	  	partida='.$this->bd->sqlvalue_inyeccion($partida,true)
		);
	
        $fecha_c		     = $this->bd->fecha($this->hoy);

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
                        $this->bd->sqlvalue_inyeccion(trim($partida) , true).",".
                        $this->bd->sqlvalue_inyeccion(trim($item) , true).",".
                        $fecha_c.",".
                        $this->bd->sqlvalue_inyeccion( $principal, true).",".
                        $this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
                        
                        
                        $this->bd->ejecutar($sql);

                        $id_asiento_d = $this->bd->ultima_secuencia('co_asientod');
                        
                        return $id_asiento_d;
         
    }
 /*
  verifica si existe asiento
  */
    function existe_emision($cajero,$fecha_caja){
        
        
        $AResultado = $this->bd->query_array('rentas.view_ren_especies',
            'count(*) as numero',
              'conta='.$this->bd->sqlvalue_inyeccion('N',true).' and
               fecha='.$this->bd->sqlvalue_inyeccion($fecha_caja,true) 
            );
        
        
            if (  $AResultado["numero"]  > 0  ){
                return 1;
            }else    {
                return 0;
            }

          


    
    }
    /*
    */
    function caja_recaudadora(){
        
        
        $AResultado = $this->bd->query_array('rentas.ren_cuenta',
            'cuenta,  idprov',
              'tipo='.$this->bd->sqlvalue_inyeccion('caja',true) 
            );
 
            return  $AResultado ;
 
    
    }
    /*
    */
    function cuenta_adicionales($tipo_cuenta){
        
        
        $AResultado = $this->bd->query_array('rentas.ren_cuenta',
            '*',
              'tipo='.$this->bd->sqlvalue_inyeccion($tipo_cuenta,true) 
            );
 
            return  $AResultado ;
 
    
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
    
    //----------------
    function _actualiza_emision($idAsiento,$sesion,$fecha_caja ){
        
        
        $sql = "UPDATE rentas.ren_movimiento 
			       SET conta =".$this->bd->sqlvalue_inyeccion('P', true)."
			     WHERE   conta= 'N' and 
                       trim(modulo) = 'especies' and 
                       fecha=" .$this->bd->sqlvalue_inyeccion($fecha_caja,true);
        
         $this->bd->ejecutar($sql);
  
  
 
    }
  
   /*
  emision de ingresos
  */
  function valida_cuenta( $cajero ,  $fecha ){
        
    
    
    $sql = "SELECT  cxcobrar, cuenta_ing, partidaa, cxcobrar_aa, cuenta_aa 
    FROM rentas.view_contabilizacion_espe
    where total > 0 and conta = 'N' and 
          fecha = ".$this->bd->sqlvalue_inyeccion(trim($fecha), true).'
          group by cxcobrar, cuenta_ing, partidaa, cxcobrar_aa, cuenta_aa';

     
      

    $stmt10 = $this->bd->ejecutar($sql);
        
    $nbandera = 1;
         
      while ($fila=$this->bd->obtener_fila($stmt10)){
                          
        $partida    =  trim($fila["partidaa"]);        
        $cxcobrar   =  trim($fila["cxcobrar"]);        
        $cuenta_ing =  trim($fila["cuenta_ing"]);        

        $lon1 = strlen( $partida);
        $lon2 = strlen( $cxcobrar );
        $lon3 = strlen( $cuenta_ing);

        if (   $lon1  < 5) {
            $nbandera = 0;
        }  
        if (   $lon2  < 5) {
            $nbandera = 0;
        } 
        if (   $lon3  < 5) {
            $nbandera = 0;
        } 
                          
      }
 
      return  $nbandera;
                            
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
    
    $fecha 			    =     $_GET["fecha_caja"];
   


    $gestion->contabilidad( $fecha);
        
    
 
    
}



?>
 
  