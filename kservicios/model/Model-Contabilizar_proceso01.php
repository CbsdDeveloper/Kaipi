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

    function contabilidad( $fecha, $cajero, $parte ,$tipo_asi	){
        

        $cajero =   $this->sesion ;

        $array_fecha   = explode("-", $fecha);
        
        $mes           = $array_fecha[1];
        $anio          = $array_fecha[0];


        $periodo_s = $this->bd->query_array('co_periodo',
        'id_periodo',
        'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
         anio ='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
         mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
        );
 
       $valida_emision =   $this->existe_emision($cajero,$fecha,$tipo_asi	);



        $result = ' EMISION YA GENERADA... verifique la informacion <br> ';


        $valida_cuenta = $this->valida_cuenta($cajero,$fecha ,$tipo_asi);
 
        //--------------------------------------------
        // contabilizacion de emision de titulos
        //--------------------------------------------
        if (  $valida_emision == 1){

            if (  $valida_cuenta == 1){

                     $idasiento = $this->agregar_asiento( $mes , $anio,  $fecha,$cajero ,$periodo_s['id_periodo'],$parte,'62','R' );

                   if ($idasiento > 0 ) {

                        $this->agregar_asiento_demision(  $mes , $anio,  $fecha,$cajero ,$periodo_s['id_periodo'],$parte, $idasiento ,$tipo_asi);

                        $comprobante =  $this->saldos->_aprobacion($idasiento);

                
                        if ($comprobante <> '-')	{
                        
                            $this->_actualiza_emision($idasiento,$cajero,$fecha,$tipo_asi	 );

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
    function agregar_asiento_demision(  $mes , $anio,  $fecha,$cajero ,$id_periodo,$parte, $idasiento  ,$tipo_asi){
        
        
        
        $principal = 'N';
        
        if ( trim($datos["partida_enlace"]) == 'gasto'){
            $principal = 'S';
        }
        
        if  ( $tipo_asi == 'N'){

            $sql = 'SELECT  partida, cxcobrar, cuenta_ing, fondoa, cuenta_ajeno, emision, iva, base12, base0, descuento, interes, recargo, total 
            FROM rentas.view_contabilizacion_emi
            where sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero), true).' and 
                  fecha = '.$this->bd->sqlvalue_inyeccion(trim($fecha), true);

        } else    {

            $sql = 'SELECT   partida, cxcobrar, cuenta_ing, fondoa, cuenta_ajeno, costo as emision, monto_iva as iva, 
            baseiva as base12, tarifa_cero base0, coalesce(descuento,0) as descuento, interes,coalesce(recargo,0) recargo, total  
            FROM rentas.view_contabilizacion
            where conta = '.$this->bd->sqlvalue_inyeccion(trim('N'), true)." and 
                  estado = 'P' and 
                  fechap = ".$this->bd->sqlvalue_inyeccion(trim($fecha), true);
              
      }    

 

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
    function existe_emision($cajero,$fecha_caja,$tipo_asi	){
        
        
        if  ( $tipo_asi== 'N'){
                
            $AResultado = $this->bd->query_array('rentas.view_contabilizacion_emi',
                    'count(*) as numero',
                    'sesion='.$this->bd->sqlvalue_inyeccion($cajero,true)
                    );

         } else    {

            $AResultado = $this->bd->query_array('rentas.view_contabilizacion',
                'count(*) as numero',
                'conta='.$this->bd->sqlvalue_inyeccion('N',true)." and 
                 estado = 'P' and 
                fechap=".$this->bd->sqlvalue_inyeccion($fecha_caja,true)  
                );
                
          }    
        
            if (  $AResultado["numero"]  > 0  ){
                return 1;
            }else    {
                return 0;
            }


    
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
    function _actualiza_emision($idAsiento,$sesion,$fecha_caja, $tipo_asi ){
        
        

        if  ( $tipo_asi == 'N'){
        
            $sql = "UPDATE rentas.ren_movimiento 
            SET conta =".$this->bd->sqlvalue_inyeccion('S', true)."
          WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($sesion),true)."  and 
                conta= 'N' and 
                modulo = 'servicios' and 
                creacion=" .$this->bd->sqlvalue_inyeccion($fecha_caja,true);
 
                $this->bd->ejecutar($sql);


         } else    {

            $sql = "UPDATE rentas.ren_movimiento 
                       SET conta =".$this->bd->sqlvalue_inyeccion('S', true)."
                     WHERE conta= 'N' and  
                           estado = 'P' and 
                           fechap=" .$this->bd->sqlvalue_inyeccion($fecha_caja,true);
 
            $this->bd->ejecutar($sql);
                
          }    


      
  

        $sql_insert = "INSERT INTO rentas.ren_cuenta_asientos (	id_asiento, tipo, fecha, sesion)
                VALUES (".
                $this->bd->sqlvalue_inyeccion($idAsiento, true).",".
                $this->bd->sqlvalue_inyeccion('emision', true).",".
                $this->bd->sqlvalue_inyeccion($fecha_caja, true).",".
                $this->bd->sqlvalue_inyeccion($sesion, true).")";
 
                $this->bd->ejecutar($sql_insert);


         
    }
  

   /*
  emision de ingresos
  */
  function valida_cuenta( $cajero ,  $fecha ,  $tipo_asi ){
        
        
    if  ( $tipo_asi == 'N'){
                 
            $sql = 'SELECT  partida, cxcobrar, cuenta_ing 
            FROM rentas.view_contabilizacion_emi
            where sesion = '.$this->bd->sqlvalue_inyeccion(trim($cajero), true).' and 
                fecha = '.$this->bd->sqlvalue_inyeccion(trim($fecha), true);

     } else    {

          
            $sql = 'SELECT  partida, cxcobrar, cuenta_ing 
            FROM rentas.view_contabilizacion
            where conta = '.$this->bd->sqlvalue_inyeccion(trim('N'), true)." and 
                  estado = 'P' and 
                  fechap = ".$this->bd->sqlvalue_inyeccion(trim($fecha), true);

             
      }    

 
   

     

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

    $tipo_asi		        =     trim($_GET["tipo_asi"]);
    

    $gestion->contabilidad( $fecha,$cajero,$parte,$tipo_asi	);
        
    
 
    
}



?>
 
  