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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];

         
        $this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
        
 
        
        
        
    }
    
    
    //--- calcula libro diario

    function contabilidad( $fecha, $cajero, $parte ){
        

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

 
        $sql = 'SELECT  partida, cxcobrar, cuenta_ing, fondoa, cuenta_ajeno, emision, iva, base12, base0, descuento, interes, recargo, total 
        FROM rentas.view_contabilizacion_emi
        where sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero), true).' and 
              fecha = '.$this->bd->sqlvalue_inyeccion(trim($fecha), true);

               
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
        
        //--------------------------------------------
        // contabilizacion de recaudacion de titulos
        //--------------------------------------------
 
 
        $result = $result . ' PROCESO PAGADO CONTABILIZADO...<br> ';

        $valida_pago =   $this->existe_pago($cajero,$fecha);

        $valida_pago_cta = $this->valida_cuenta_pago($cajero,$fecha );
        
        $valida_pago_cta_anio = $this->valida_cuenta_pago_anio($cajero,$fecha );

      
 
         
 
      if (  $valida_pago == 1){

                if (   $valida_pago_cta == 1 ){

                    if (   $valida_pago_cta_anio == 1 ){
                    
                         $idasiento = $this->agregar_asiento( $mes , $anio,  $fecha,$cajero ,$periodo_s['id_periodo'],$parte,'11','X' );

                           if ($idasiento > 0 ) {

                                        $this->agregar_asiento_dpago(  $mes , $anio,  $fecha,$cajero ,$periodo_s['id_periodo'],$parte, $idasiento );

                                   $comprobante =  $this->saldos->_aprobacion($idasiento);
                
                                       if ($comprobante <> '-')	{
                                        
                                           $this->_actualiza_pago($idasiento,$cajero,$fecha );

                                            $result =  $result .' SE APROBO EL ASIENTO NRO. DE PAGO '.  $idasiento .'<br>';
                                        
                                    
                                        }else{
                        
                                            $result =  $result .' NO SE APROBO EL ASIENTO... REVISE AUXILIARES - ENLACES PRESUPUESTARIOS INGRESO - GASTO';
  
                                         }
                            
                           }      
                }else {
                        
                    $result =  $result .' NO SE GENERO EL ASIENTO... REVISE CUENTAS PARAMETRIZACION';

                }
            }   
        } 
     
       
      
 
        echo $result;
    }
    //	-----------------------------------------------------
    function agregar_asiento( $mes , $anio,  $fecha_registro,$cajero ,$id_periodo,$parte , $cuenta ,$tipo_mov ){
            
             $estado         =  'digitado';

             $fecha		     = $this->bd->fecha($fecha_registro);

             if ( $tipo_mov == 'X'){
                  $detalle        = 'Registro de Recaudacion de ingresos dia: '.$fecha_registro.' usuario: '.$cajero.' referencia: '.$parte;
             }else{
                 $detalle        = 'Registro de emision de ingresos dia: '.$fecha_registro.' usuario: '.$cajero.' referencia: '.$parte;
           }

             $secuencial     =  trim($parte);
             $idprov         =  $this->ruc     ;
             $cuenta         =  $cuenta;
             $total_apagar   =  0;
             $tramite        =  0;
             $id_movimiento  =  0;
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
										        $fecha.",".
										        $this->bd->sqlvalue_inyeccion('contabilidad', true).",".
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
        

        $sql = 'SELECT  partida, cxcobrar, cuenta_ing, fondoa, cuenta_ajeno, emision, iva, base12, base0, descuento, interes, recargo, total 
                    FROM rentas.view_contabilizacion_emi
                    where sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero), true).' and 
                          fecha = '.$this->bd->sqlvalue_inyeccion(trim($fecha), true);

       
 

        $stmt1 = $this->bd->ejecutar($sql);
            
             
          while ($fila=$this->bd->obtener_fila($stmt1)){
                              
            $partida    =  trim($fila["partida"]);        
            $cxcobrar   =  trim($fila["cxcobrar"]);        
            $cuenta_ing =  trim($fila["cuenta_ing"]);        

            $descuento =  trim($fila["descuento"]);     
        
            $debe   =  '0.00' ;


            $haber  = $fila["emision"] -   $descuento ;

           $this->agregar_detalle($idasiento,$cuenta_ing,$partida ,$debe,$haber,$id_periodo,$anio,$mes);


            $debe   = $fila["emision"] -  $descuento ;
            $haber  = '0.00' ;
             $this->agregar_detalle($idasiento,$cxcobrar,$partida ,$debe,$haber,$id_periodo,$anio,$mes);

                              
          }
 	
								
    }
   /*
  emision de ingresos caja
  */
  function agregar_asiento_dpago(  $mes , $anio,  $fecha,$cajero ,$id_periodo,$parte, $idasiento  ){
        

    $principal = 'N';
    
    $sql1 = 'SELECT   anio, partida, cxcobrar, cuenta_ing,  fondoa, cuenta_ajeno,
                    sum(emision) emision , 
                    sum(iva) as iva, 
                    sum(base12) as base12, 
                    sum(base0) as base0, 
                    sum(descuento) as descuento, 
                    sum(interes) as interes, 
                    sum(recargo) as recargo 
                FROM rentas.view_contabilizacion_pago
                where sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero), true).' and 
                      fecha = '.$this->bd->sqlvalue_inyeccion(trim($fecha), true)." and  
                      conta = 'S' and 
                      anio = ".$this->bd->sqlvalue_inyeccion(trim($anio), true)."
               group by  anio, partida, cxcobrar, cuenta_ing,  fondoa, cuenta_ajeno";

 

    $stmt2 = $this->bd->ejecutar($sql1);
        
      $total = 0;
         
      while ($fila=$this->bd->obtener_fila($stmt2)){
                          
        $partida    =  trim($fila["partida"]);        
        $cxcobrar   =  trim($fila["cxcobrar"]);        
        $cuenta_ing =  trim($fila["cuenta_ing"]);        

        $descuento =  trim($fila["descuento"]);     
     
        $debe   =  '0.00' ;
        $haber  = $fila["emision"]  -   $descuento;

        $this->agregar_detalle($idasiento,$cxcobrar,$partida ,$debe,$haber,$id_periodo,$anio,$mes);

        $total = $total +   $haber ;
                          
      }

      /* años anteriores */

            $sql1 = 'SELECT   partidaa ,cxcobrar_aa ,cuenta_aa ,
                        sum(emision) emision , 
                        sum(iva) as iva, 
                        sum(base12) as base12, 
                        sum(base0) as base0, 
                        sum(descuento) as descuento, 
                        sum(interes) as interes, 
                        sum(recargo) as recargo 
                    FROM rentas.view_contabilizacion_pago
                    where sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero), true).' and 
                            fecha = '.$this->bd->sqlvalue_inyeccion(trim($fecha), true)." and  
                            conta = 'S' and 
                            anio < ".$this->bd->sqlvalue_inyeccion( $anio , true)."
                    group by  partidaa ,cxcobrar_aa ,cuenta_aa";


            $total_anterior = 0;

            $stmt3 = $this->bd->ejecutar($sql1);

            while ($fila1=$this->bd->obtener_fila($stmt3)){
                        
                    $partida    =  trim($fila1["partidaa"]);        
                    $cxcobrar   =  trim($fila1["cxcobrar_aa"]);        
                    $cuenta_ing =  trim($fila1["cuenta_aa"]);        

        
                    $debe   =  '0.00' ;
                    $haber  = $fila1["emision"]  ;

                    $this->agregar_detalle($idasiento,$cxcobrar,$partida ,$haber,$debe,$id_periodo,$anio,$mes);
                    $this->agregar_detalle($idasiento,$cxcobrar,$partida ,$debe,$haber,$id_periodo,$anio,$mes);
                    $this->agregar_detalle($idasiento,$cuenta_ing,$partida ,$debe,$haber,$id_periodo,$anio,$mes);

                    $total_anterior = $total_anterior +   $haber ;
                        
            }



      /*
      contabilizacion de recargo
      */ 

      $total_recargo = 0;

      $x_recargo = $this->bd->query_array('rentas.view_contabilizacion_pago',  
                                        'sum(recargo) as recargo',                         
                                        'sesion='.$this->bd->sqlvalue_inyeccion($cajero,true)  .' and 
                                         fecha = '.$this->bd->sqlvalue_inyeccion(trim($fecha), true)." and  
                                         conta = 'S' " 
      );

     if  ( $x_recargo['recargo'] > 0  ){

         $cuenta_recargo =   $this->cuenta_adicionales('recargo');

         $partida    =  trim($cuenta_recargo["partida"]);        
         $cxcobrar   =  trim($cuenta_recargo["cuenta"]);        
         $cuenta_ing =  trim($cuenta_recargo["ccuenta"]);        

     
         $debe   =  '0.00' ;
         $haber  = $x_recargo["recargo"] ;

         $this->agregar_detalle($idasiento,$cuenta_ing,$partida ,$debe,$haber,$id_periodo,$anio,$mes);


         $debe   = $x_recargo["recargo"] ;
         $haber  = '0.00' ;
         $this->agregar_detalle($idasiento,$cxcobrar,$partida ,$debe,$haber,$id_periodo,$anio,$mes);

         $debe   =  '0.00' ;
         $haber  = $x_recargo["recargo"] ;
         $this->agregar_detalle($idasiento,$cxcobrar,$partida ,$debe,$haber,$id_periodo,$anio,$mes);

         $total_recargo =  $x_recargo['recargo'] ;

     }

      /*
      contabilizacion de descuento
      */ 

      $total_descuento = 0;

      $x_descuento = $this->bd->query_array('rentas.view_contabilizacion_pago',  
                                        'sum(descuento) as descuento',                         
                                        'sesion='.$this->bd->sqlvalue_inyeccion($cajero,true)  .' and 
                                         fecha = '.$this->bd->sqlvalue_inyeccion(trim($fecha), true)." and  
                                         conta = 'S' " 
      );
/*
      if  ( $x_descuento['descuento'] > 0  ){

        $cuenta_descuento =   $this->cuenta_adicionales('descuento');

        $partida    =  trim($cuenta_descuento["partida"]);        
        $cxxpagar   =  trim($cuenta_descuento["cuenta"]);        
        $cuenta_gas =  trim($cuenta_descuento["ccuenta"]);        

        $idprov     =  trim($cuenta_descuento["idprov"]);        
 
    
        $debe    =  '0.00' ;
        $haber   = $x_descuento["descuento"] ;
        $detalle = 'Registro de Recaudacion - Descuentos de ingresos dia: '.$fecha.' usuario: '.$cajero.' referencia: '.$parte;

        $id_asiento_d = $this->agregar_detalle($idasiento,$cxxpagar,$partida ,$debe,$haber,$id_periodo,$anio,$mes);

        $this->saldos->_aux_contable_bancos($fecha,$idasiento,
                                            $id_asiento_d,
                                            $detalle,
                                            $cxxpagar,
                                            $idprov,
                                            $debe,$haber,
                                            0,
                                            'S',
                                            '0',
                                            'cxpagar',
                                            '0');


        $debe   = $x_descuento["descuento"] ;
        $haber  = '0.00' ;
        $id_asiento_d = $this->agregar_detalle($idasiento,$cxxpagar,$partida ,$debe,$haber,$id_periodo,$anio,$mes);

        $this->saldos->_aux_contable_bancos($fecha,$idasiento,
                                          $id_asiento_d,
                                          $detalle,
                                          $cxxpagar,
                                          $idprov,
                                          $debe,$haber,
                                          0,
                                          'S',
                                          '0',
                                          'cxpagar',
                                          '0');



        $debe   = $x_descuento["descuento"] ;
        $haber  = '0.00' ;
        $this->agregar_detalle($idasiento,$cuenta_gas,$partida ,$debe,$haber,$id_periodo,$anio,$mes);

        $total_descuento =  $x_descuento['descuento'] ;
      
        $detalle = 'Registro Descuentos por recaudacion del dia: '.$fecha.' usuario: '.$cajero.' referencia: '.$parte;

       $id_tramite =  $this->generar_compromiso(    $detalle,$fecha,$parte ,$partida,$total_descuento);


       $sql_uno = 'UPDATE co_asiento
						 		       SET  id_tramite='.$this->bd->sqlvalue_inyeccion( $id_tramite, true).'
								  WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($idasiento ,true);
						
                                  $this->bd->ejecutar($sql_uno);
   
     
    } */



      /*  cierre de caja */
      $datos =  $this->caja_recaudadora();

      $debe         =   ( $total + $total_anterior  + $total_recargo ) -  $total_descuento;
      $haber        =   '0.00';
      $cuenta_ing   =    trim($datos["cuenta"]);   
      $idprov       =    trim($datos["idprov"]);   

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
        
        
        $AResultado = $this->bd->query_array('rentas.view_contabilizacion_emi',
            'count(*) as numero',
              'sesion='.$this->bd->sqlvalue_inyeccion($cajero,true).' and
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
    function existe_pago($cajero,$fecha_caja){
        
        
        $AResultado = $this->bd->query_array('rentas.view_contabilizacion_pago',
            'count(*) as numero',
              'sesion='.$this->bd->sqlvalue_inyeccion($cajero,true)." and  
               conta = 'S' and 
               fecha=".$this->bd->sqlvalue_inyeccion($fecha_caja,true) 
            );
 

            if (  $AResultado["numero"]  > 0  ){
                return 1;
            }else    {
                return 0;
            }

    
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
			       SET conta =".$this->bd->sqlvalue_inyeccion('S', true)."
			     WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($sesion),true)."  and 
                       conta= 'N' and 
                       modulo = 'servicios' and 
                       creacion=" .$this->bd->sqlvalue_inyeccion($fecha_caja,true);
        
         $this->bd->ejecutar($sql);
  

        $sql_insert = "INSERT INTO rentas.ren_cuenta_asientos (	id_asiento, tipo, fecha, sesion)
                VALUES (".
                $this->bd->sqlvalue_inyeccion($idAsiento, true).",".
                $this->bd->sqlvalue_inyeccion('emision', true).",".
                $this->bd->sqlvalue_inyeccion($fecha_caja, true).",".
                $this->bd->sqlvalue_inyeccion($sesion, true).")";
 
                $this->bd->ejecutar($sql_insert);


         
    }
    /*
    */
    function _actualiza_pago($idAsiento,$sesion,$fecha_caja ){
        
        
        $sql = "UPDATE rentas.ren_movimiento 
			       SET conta =".$this->bd->sqlvalue_inyeccion('P', true)."
			     WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($sesion),true)."  and 
                       conta= 'S' and 
                       estado= 'P' and 
                       modulo = 'servicios' and 
                       fechap=" .$this->bd->sqlvalue_inyeccion($fecha_caja,true);
        
        $this->bd->ejecutar($sql);
  

        $sql_insert = "INSERT INTO rentas.ren_cuenta_asientos (	id_asiento, tipo, fecha, sesion)
                VALUES (".
                $this->bd->sqlvalue_inyeccion($idAsiento, true).",".
                $this->bd->sqlvalue_inyeccion('pagado', true).",".
                $this->bd->sqlvalue_inyeccion($fecha_caja, true).",".
                $this->bd->sqlvalue_inyeccion($sesion, true).")";
 
                $this->bd->ejecutar($sql_insert);
        
    }

   /*
  emision de ingresos
  */
  function valida_cuenta( $cajero ,  $fecha ){
        
        

    
    $sql = 'SELECT  partida, cxcobrar, cuenta_ing 
    FROM rentas.view_contabilizacion_emi
    where sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero), true).' and 
          fecha = '.$this->bd->sqlvalue_inyeccion(trim($fecha), true);

     

    $stmt10 = $this->bd->ejecutar($sql);
        
    $nbandera = 1;
         
      while ($fila=$this->bd->obtener_fila($stmt10)){
                          
        $partida    =  trim($fila["partida"]);        
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

/*
  validacion de cuentas para recaudacion de ingresos
  */
  function valida_cuenta_pago( $cajero ,  $fecha ){
        
 
    
    $sql = 'SELECT partida, cxcobrar, cuenta_ing, fondoa, cuenta_ajeno
    FROM rentas.view_contabilizacion_pago
    where sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero), true)." and   
          conta = 'S' and
          fecha = ".$this->bd->sqlvalue_inyeccion(trim($fecha), true).'  
          group by anio, partida, cxcobrar, cuenta_ing, fondoa, cuenta_ajeno';

     

    $stmt10 = $this->bd->ejecutar($sql);
        
    $nbandera = 1;
         
      while ($fila=$this->bd->obtener_fila($stmt10)){
                          
        $partida    =  trim($fila["partida"]);        
        $cxcobrar   =  trim($fila["cxcobrar"]);        
        $cuenta_ing =  trim($fila["cuenta_ing"]);        

        $fondoa =  trim($fila["fondoa"]);        

        $cuenta_ajeno =  trim($fila["cuenta_ajeno"]);        



        $lon1 = strlen( $partida);
        $lon2 = strlen( $cxcobrar );
        $lon3 = strlen( $cuenta_ing);
        $lon4 = strlen( $cuenta_ajeno);

        if (   $lon1  < 5) {
            $nbandera = 0;
        }  
        if (   $lon2  < 5) {
            $nbandera = 0;
        } 
        if (   $lon3  < 5) {
            $nbandera = 0;
        } 

        if ($fondoa  == 'S'){
            if (   $lon4  < 5) {
                $nbandera = 0;
            } 
        }     
                          
      }
 
      return  $nbandera;
                            
}   


/*
  validacion de cuentas para recaudacion de ingresos
  */
  function valida_cuenta_pago_anio( $cajero ,  $fecha ){
        
 
    $anio_anterio =  $this->anio  - 1;

    $sql = 'SELECT partidaa ,cxcobrar_aa ,cuenta_aa 
    FROM rentas.view_contabilizacion_pago
    where sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero), true)." and   
          conta = 'S' and
          anio  < ".$this->bd->sqlvalue_inyeccion(trim($anio_anterio), true)." and 
          fecha = ".$this->bd->sqlvalue_inyeccion(trim($fecha), true).'  
          group by partidaa ,cxcobrar_aa ,cuenta_aa ';

     

    $stmt10 = $this->bd->ejecutar($sql);
        
    $nbandera = 1;
         
      while ($fila=$this->bd->obtener_fila($stmt10)){
                          
        $partida    =  trim($fila["partidaa"]);        
        $cxcobrar   =  trim($fila["cxcobrar_aa"]);        
        $cuenta_ing =  trim($fila["cuenta_aa"]);        
 
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
/*
  validacion de cuentas para recaudacion de ingresos
  */
  function generar_compromiso(  $detalle,$fecha,$parte ,$partida,$monto){
        
 
     
    $anio       =  $_SESSION['anio'];

    $tabla 	  	  = 'presupuesto.pre_tramite';
                
    $secuencia 	  = 'presupuesto.pre_tramite_id_tramite_seq';

    $observacion  = 'Enlace recaudacion-descuentos';
                
    $ATabla = array(
        array( campo => 'id_tramite',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
        array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => $fecha, key => 'N'),
        array( campo => 'registro',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
        array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor =>  $anio  , key => 'N'),
        array( campo => 'mes',tipo => 'NUMBER',id => '4',add => 'S', edit => 'N', valor => '01', key => 'N'),
        array( campo => 'detalle',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor =>  $detalle, key => 'N'),
        array( campo => 'observacion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor =>  $observacion, key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
        array( campo => 'sesion_asigna',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
        array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
        array( campo => 'comprobante',tipo => 'VARCHAR2',id => '10',add => 'N', edit => 'N', valor => '-', key => 'N'),
        array( campo => 'estado',tipo => 'VARCHAR2',id => '11',add => 'S', edit =>'N', valor => '6', key => 'N'),
        array( campo => 'tipo',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => '-', key => 'N'),
        array( campo => 'documento',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $parte, key => 'N'),
        array( campo => 'id_departamento',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '20', key => 'N'),
        array( campo => 'idprov',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor => $idprov, key => 'N'),
        array( campo => 'planificado',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => 'N', key => 'N'),
        array( campo => 'id_asiento_ref',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'marca',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'N', valor => '-', key => 'N'),
        array( campo => 'solicita',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor =>  $this->sesion, key => 'N') ,
        array( campo => 'tipocp',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N') ,
        array( campo => 'fcertifica',tipo => 'DATE',id => '21',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
        array( campo => 'fcompromiso',tipo => 'DATE',id => '22',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
        array( campo => 'fdevenga',tipo => 'DATE',id => '23',add => 'S', edit => 'S', valor => $this->hoy , key => 'N')
     );

 

     $id_tramite = $this->bd->_InsertSQL($tabla,$ATabla,$secuencia );

     $tabla 	  	     = 'presupuesto.pre_tramite_det';
     $secuencia 	     = 'presupuesto.pre_tramite_det_id_tramite_det_seq';
     
     $ATabla_a = array(
         array( campo => 'id_tramite_det',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
         array( campo => 'id_tramite',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor =>$id_tramite, key => 'N'),
         array( campo => 'partida',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $partida, key => 'N'),
         array( campo => 'saldo',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
         array( campo => 'iva',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '0', key => 'N'),
         array( campo => 'base',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => $monto, key => 'N'),
         array( campo => 'certificado',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor =>$monto, key => 'N'),
         array( campo => 'compromiso',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => $monto, key => 'N'),
         array( campo => 'devengado',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor =>$monto, key => 'N'),
         array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
         array( campo => 'fsesion',tipo => 'DATE',id => '10',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
         array( campo => 'registro',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
         array( campo => 'anio',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor =>  $this->anio, key => 'N')
      );

      $this->bd->_InsertSQL($tabla,$ATabla_a,$secuencia );
 
      return  $id_tramite;
                            
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
if (isset($_GET["fecha"]))	{
    
    $fecha 			    =     $_GET["fecha"];
    $cajero 		    =     trim($_GET["cajero"]);
    $parte		        =     trim($_GET["parte"]);


    $gestion->contabilidad( $fecha,$cajero,$cajero);
        
    
 
    
}



?>
 
  